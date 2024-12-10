<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;
use App\Enums\CampanhasStatus;

class CampanhasModel extends Model
{
    protected $table            = 'campanhas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false; //??? porque eu gostaria de proteger campos???
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getCampanhas()
    {
        $queryString = "SELECT camp.*, stat.nome as status_nome FROM campanhas as camp, campanhas_status as stat WHERE camp.campanhas_status_id == stat.id";
        return $this->query($queryString)->getResultArray();
        // return $this->findAll();
    }

    public function getCampanha($id)
    {

        $campanha = $this->find($id);
        $detalhesCampanha = $this->getDetalhesCampanha($id);
        $data = array_merge($campanha, $detalhesCampanha);

        return $data;

    }

    public function getDetalhesCampanha($id)
    {

        // contatos que pertencem a campanha

        $arrayContatosSelecionados =  $this->query("SELECT cont.* FROM contatos as cont, campanhas_contatos_templates as camp WHERE cont.id == camp.contatos_id AND camp.campanhas_id = ".$id)->getResultArray();
        $data['contatosSelecionados'] = $arrayContatosSelecionados;
        $data['idsContatosSelecionados'] = array_map( fn($e) => $e['id'] ?? "", $arrayContatosSelecionados );

        // template que pertencem a campanha
        // DISTINCT: campanha tem apenas um template
        
        $arrayTemplatesSelecionados =  $this->query("SELECT DISTINCT templ.* FROM templates as templ, campanhas_contatos_templates as camp WHERE templ.id == camp.templates_id AND camp.campanhas_id = ".$id)->getResultArray();
        $data['templatesSelecionados'] = $arrayTemplatesSelecionados;
        $data['idsTemplatesSelecionados'] = array_map( fn($e) => $e['id'] ?? "", $arrayTemplatesSelecionados );

        return $data;

    }


    public function removeCampanha($id) : bool
    {

        $db = Database::connect();

        $deleteQuery = "DELETE FROM campanhas_contatos_templates WHERE campanhas_id = ".$id;
        $db->query($deleteQuery);

        return $this->delete($id);
    }

    public function salvaCampanha($data)
    {

        // TODO: persistência N:N feita manualmente para fins didáticos. Encontrar a maneira otimizada de fazer isso

        // Passo 1 - salva uma campanha
        $campanha['nome'] = $data['nome'];
        $campanha['data_criacao'] = $data['data_criacao'];
        $campanha['campanhas_status_id'] = $data['campanhas_status_id'] ?? CampanhasStatus::NAO_EXECUTADO;
        
        if( isset($data['id']) ){
            $idCampanha = $data['id'];
            $this->update($idCampanha, $campanha); 
        } else {
            $idCampanha = $this->insert($campanha);
        }

        // print_r($data); dd();

        // Passo 2 - salva dados na tabela campanhas_contatos_templates (N:N)
        
        $db = Database::connect();

        // TODO: vou fazer update assim: delete e depois insert
        $deleteQuery = "DELETE FROM campanhas_contatos_templates WHERE campanhas_id = ".$idCampanha;
        $db->query($deleteQuery);

        $arrayInsertQueries = [];
        foreach ($data['idsContatosSelecionados'] as $idContatoSelecionado) {
            foreach ($data['idsTemplatesSelecionados'] as $idTemplateSelecionado) {
                $arrayInsertQueries[] = "INSERT INTO \"campanhas_contatos_templates\" (\"id\", \"campanhas_id\", \"contatos_id\", \"templates_id\") VALUES (NULL, ".$idCampanha.", ".$idContatoSelecionado.", ".$idTemplateSelecionado.")";
            }
        }

        // print_r($data);
        // print_r($arrayInsertQueries); dd();

        // persiste relacionamento N:N

        foreach ($arrayInsertQueries as $sql) {
            $db->query($sql);
            // echo $db->affectedRows();
        }

    }

    public function executaCampanha($id) : bool
    {

        $contErros = 0;

        try {

            // Busca todos dados da campanha
            $arrayDetalhesCampanha = $this->getCampanha($id);

            //Inicia execução da campanha
            $arrayDetalhesCampanha['campanhas_status_id'] = CampanhasStatus::EM_EXECUCAO;
            $this->salvaCampanha($arrayDetalhesCampanha);
            
            // Monta email para cada contato
            foreach ($arrayDetalhesCampanha['contatosSelecionados'] as $contato) {
                
                $email = service('email');
                $email->clear();
                $email->setTo($contato['email']);
                $email->setSubject('Custom Content - '.$arrayDetalhesCampanha['nome']);
                
                // Anexa dados do contato no template
                // TODO: Tags sem um valor correspondente continuaram na string como estavam. Exemplo: {nao_existe} continuou {nao_existe}
                $parser = service('parser');
                $arrayDetalhesTemplate = $arrayDetalhesCampanha['templatesSelecionados'][0];
                $mensagem = $parser->setData($contato)->renderString($arrayDetalhesTemplate['mensagem']);
                $email->setMessage($mensagem);

                $wasEmailEnviado = $email->send(false);

                //TODO: Persistir todo envio de email para permitir analise posterior na tabela 'campanhas_contatos_templates', guardar boolean de exito e o log do servidor smtp
                //echo '<pre>'; print_r( $email->printDebugger() ); echo '</pre>';

                if(!$wasEmailEnviado) $contErros++;

            }

            //Finaliza execução da campanha
            if ($contErros == 0) {
                $arrayDetalhesCampanha['campanhas_status_id'] = CampanhasStatus::FINALIZADO_COM_SUCESSO;
                $this->salvaCampanha($arrayDetalhesCampanha);
            }else{
                $arrayDetalhesCampanha['campanhas_status_id'] = CampanhasStatus::ERRO;
                $this->salvaCampanha($arrayDetalhesCampanha);
                //throw new Exception('E-mail não foi enviado');
            }

        } catch (\Throwable $th) {
            
            throw $th;

        }

        return true;

    }

}
