<?php

namespace App\Controllers;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

use CodeIgniter\View\Table;

class CampanhasController extends BaseController
{
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

        $data = $this->request->getPost();

        if( empty($data) || in_array("", $data) ) return redirect()->back();

        $campanhasModel = model(CampanhasModel::class);
        
        if( $campanhasModel->salvaCampanha($data) ) return redirect('campanhas');
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

