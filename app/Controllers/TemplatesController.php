<?php

namespace App\Controllers;

use App\Models\TemplatesModel;
use CodeIgniter\View\Table;

class TemplatesController extends BaseController
{
    public function index(): string
    {

        helper('text');
        
        $data['title'] = "Templates";

        $data['btn_novo_template'] = '<a href="/templates/novo">[novo template]</a>';

        $templatesModel = model(TemplatesModel::class);
        $templates = $templatesModel->getTemplates();

        foreach ($templates as $key => $template) {

            //TODO: assunto e mensagem devem ser de preenchimento obrigatorios
            $templates[$key]['assunto'] = character_limiter($template['assunto'], 20, '...');
            $templates[$key]['mensagem'] = character_limiter($template['mensagem'], 20, '...');
            
            //Adiciona botões CRUD em cada template
            $templates[$key]['link_editar'] = '<a href="/templates/editar/'.$template['id'].'">editar</a>';
            $templates[$key]['link_excluir'] = '<a href="/templates/excluir/'.$template['id'].'">excluir</a>';  
        }

        $arrayHeader = array_key_exists(0, $templates) ? array_keys($templates[0]) : "";

        $table = new Table();
        $table->setHeading($arrayHeader);
        $data['content'] = $table->generate($templates);

        return
            view('contents/header', $data).
            view('templates/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['title'] = "Cadastrar Novo Template";

        // busca todos os contatos
        

        // busca todos os templates

        return
            view('contents/header', $data).
            view('templates/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['title'] = "Editar Template";

        $templatesModel = model(TemplatesModel::class);
        $arrayDetalhesTemplate = $templatesModel->getTemplate($id);

        $data = array_merge($data, $arrayDetalhesTemplate);

        return
            view('contents/header', $data).
            view('templates/form', $data).
            view('contents/footer', $data);
    }


    public function salvar()
    {

        $data = $this->request->getPost();

        if( empty($data) || in_array("", $data) ) return redirect()->back();

        //print_r($data); dd();

        $templatesModel = model(TemplatesModel::class);
        
        // save() = insert() or update()
        $templatesModel->save($data);

        return redirect('templates');

    }

    public function excluir($id)
    {
        $templatesModel = model(TemplatesModel::class);

        if( $templatesModel->removeTemplate($id) ) return redirect('templates');
        throw new Exception("Erro ao deletar");

    }
}
