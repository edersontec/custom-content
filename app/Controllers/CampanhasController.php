<?php

namespace App\Controllers;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

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
        }

        $arrayHeader = array_key_exists(0, $campanhas) ? array_keys($campanhas[0]) : "";

        $table = new \CodeIgniter\View\Table();
        $table->setHeading($arrayHeader);
        $data['content'] = $table->generate($campanhas);

        return
            view('contents/header', $data).
            view('campanhas/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['title'] = "Cadastrar Novo Campanha";
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

        $db = \Config\Database::connect();
        $arrayIdsContatosSelecionados =  $db->query("SELECT contatos_id as arrayIdsContatosSelecionados FROM campanhas_contatos_templates WHERE campanhas_id = ".$id)->getResultArray();
        //converte array multi-dimensional para array unico
        $data['arrayIdsContatosSelecionados'] = array_map( fn($e) => array_values($e)[0] ?? "", $arrayIdsContatosSelecionados );

        $arrayIdsTemplatesSelecionados = $db->query("SELECT templates_id as arrayIdsTemplatesSelecionados FROM campanhas_contatos_templates WHERE campanhas_id = ".$id)->getResultArray();
        //converte array multi-dimensional para array unico
        $data['arrayIdsTemplatesSelecionados'] = array_map( fn($e) => array_values($e)[0] ?? "", $arrayIdsTemplatesSelecionados );


        $campanhasModel = model(CampanhasModel::class);
        $arrayDetalhesCampanha = $campanhasModel->getCampanha($id);

        $data = array_merge($data, $arrayDetalhesCampanha);

        // echo'<pre>'; print_r($data); echo'</pre>';// dd();

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
        
        // save() = insert() or update()
        $campanhasModel->salvaCampanha($data);

        return redirect('campanhas');

    }

    public function excluir($id)
    {
        
        $campanhasModel = model(CampanhasModel::class);

        if( $campanhasModel->removeCampanha($id) ) return redirect('campanhas');
        throw new Exception("Erro ao deletar");

    }
}

