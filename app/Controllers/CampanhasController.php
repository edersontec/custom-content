<?php

namespace App\Controllers;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

use CodeIgniter\View\Table;

class CampanhasController extends BaseController
{
    private const DICA = "Uma campanha mescla contatos e um template. Seu objetivo é disparar uma mensagem personalizada para cada contato selecionado";

    protected $helpers = ['form'];

    public function index(): string
    {

        $data['hasTabelas'] = true;
        $data['hasIcones'] = true;

        $data['titulo'] = "Campanhas";
        $data['subtitulo'] = self::DICA;

        $campanhasModel = model(CampanhasModel::class);
        $campanhas = $campanhasModel->getCampanhas();

        foreach ($campanhas as $key => $campanha) {
            
            //Adiciona botões CRUD em cada campanha
            $campanhas[$key]['link_editar'] = '<a href="'.base_url('campanhas/editar/'.$campanha['id']).'" class="btn btn-secondary"><i class="bi bi-pen"></a>';
            $campanhas[$key]['link_excluir'] = '<a href="'.base_url('campanhas/excluir/'.$campanha['id']).'" class="btn btn-danger"><i class="bi bi-trash"></a>';  
            $campanhas[$key]['link_executar'] = '<a href="'.base_url('campanhas/executar/'.$campanha['id']).'" class="btn btn-primary"><i class="bi bi-send"></a>'; 
        }

        $table = new Table();

        $arrayHeader = array_key_exists(0, $campanhas) ? array_keys($campanhas[0]) : "";
        $table->setHeading($arrayHeader);

        $template = [ 'table_open' => '<table id="tabela_campanhas">' ];
        $table->setTemplate($template);
        
        $data['conteudo'] = $table->generate($campanhas);

        return
            view('contents/header', $data).
            view('campanhas/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['titulo'] = "Cadastrar nova campanha";
        $data['subtitulo'] = self::DICA;
        $data['contatos'] = model(ContatosModel::class)->getContatos();
        $data['templates'] = model(TemplatesModel::class)->getTemplates();

        return
            view('contents/header', $data).
            view('campanhas/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['titulo'] = "Editar campanha";
        $data['subtitulo'] = self::DICA;
        $data['contatos'] = model(ContatosModel::class)->getContatos();
        $data['templates'] = model(TemplatesModel::class)->getTemplates();

        $arrayCampanha = model(CampanhasModel::class)->getCampanha($id);
        $data = array_merge($data, $arrayCampanha);

        return
            view('contents/header', $data).
            view('campanhas/form', $data).
            view('contents/footer', $data);
    }


    public function salvar()
    {

        // validação
        $rules = [
            'nome' => 'required|max_length[100]',
            'idsContatosSelecionados.*' => 'required|max_length[10]|is_natural',
            'idsTemplatesSelecionados.*' => 'required|max_length[10]|is_natural',
            'data_criacao' => 'permit_empty|valid_date[Y-m-d H:i:s]',
            'id' => 'permit_empty|is_natural',
            'campanhas_status_id' => 'permit_empty|is_natural',
        ];

        $data = $this->request->getPost();

        if ( !$this->validateData($data, $rules) ) {
            return redirect()->back()->withInput();
        }
 
        // sanitização
        $validData = $this->validator->getValidated();
        $validData = esc($validData);

        $campanhasModel = model(CampanhasModel::class);
        
        if( $campanhasModel->salvaCampanha($validData) ) return redirect('campanhas');
        throw new Exception("Erro ao deletar campanha");

    }

    public function excluir($id)
    {
        
        $campanhasModel = model(CampanhasModel::class);

        if( $campanhasModel->removeCampanha($id) ) return redirect('campanhas');
        throw new Exception("Erro ao deletar campanha");

    }

    public function executar($id)
    {

        $campanhasModel = model(CampanhasModel::class);

        if( $campanhasModel->executaCampanha($id) ) return redirect('campanhas');
        throw new Exception("Erro ao executar campanha");

    }

}

