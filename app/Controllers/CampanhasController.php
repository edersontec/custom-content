<?php

namespace App\Controllers;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

use CodeIgniter\View\Table;

class CampanhasController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {

        $data['title'] = "Campanhas";
        $data['btn_nova_campanha'] = '<a href="/campanhas/novo">[nova campanha]</a>';

        $campanhasModel = model(CampanhasModel::class);
        $campanhas = $campanhasModel->getCampanhas();

        foreach ($campanhas as $key => $campanha) {
            
            //Adiciona botões CRUD em cada campanha
            $campanhas[$key]['link_editar'] = '<a href="/campanhas/editar/'.$campanha['id'].'">editar</a>';
            $campanhas[$key]['link_excluir'] = '<a href="/campanhas/excluir/'.$campanha['id'].'">excluir</a>';
            $campanhas[$key]['link_executar'] = '<a href="/campanhas/executar/'.$campanha['id'].'">executar</a>';
        }

        $table = new Table();

        $arrayHeader = array_key_exists(0, $campanhas) ? array_keys($campanhas[0]) : "";
        $table->setHeading($arrayHeader);
        
        $data['content'] = $table->generate($campanhas);

        return
            view('contents/header', $data).
            view('campanhas/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['title'] = "Cadastrar Nova Campanha";
        $data['contatos'] = model(ContatosModel::class)->getContatos();
        $data['templates'] = model(TemplatesModel::class)->getTemplates();

        return
            view('contents/header', $data).
            view('campanhas/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['title'] = "Editar Campanha";
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

