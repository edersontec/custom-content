<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

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
        return $this->findAll();
    }

    public function getCampanha($id)
    {
        return $this->find($id);
    }

    public function removeCampanha($id) : bool
    {

        $db = Database::connect();

        $deleteQuery = "DELETE FROM campanhas_contatos_templates WHERE campanhas_id = ".$id;
        $db->query($deleteQuery);

        return $this->delete($id);
    }

    public function salvaCampanha($data){

        // TODO: persistência N:N feita manualmente para fins didáticos. Encontrar a maneira otimizada de fazer isso

        // Passo 1 - salva uma campanha
        $campanha['nome'] = $data['nome'];
        $campanha['data_criacao'] = $data['data_criacao'];
        
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
        foreach ($data['contatosSelecionados'] as $idContatoSelecionado) {
            foreach ($data['templatesSelecionados'] as $idTemplateSelecionado) {
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


}
