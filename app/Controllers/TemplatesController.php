<?php

namespace App\Controllers;

use App\Models\TemplatesModel;
use CodeIgniter\View\Table;

class TemplatesController extends BaseController
{
    private const DICA = "Um template é mensagem padronizada. É possível produzir mensagens personalizadas adicionando tags de contato";

    protected $helpers = ['form', 'text'];

    public function index(): string
    {
        
        $data['titulo'] = "Templates";
        $data['subtitulo'] = self::DICA;

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

        $table = new Table();
        
        $arrayHeader = array_key_exists(0, $templates) ? array_keys($templates[0]) : "";
        $table->setHeading($arrayHeader);
        
        $data['conteudo'] = $table->generate($templates);

        return
            view('contents/header', $data).
            view('templates/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['titulo'] = "Cadastrar novo template";
        $data['subtitulo'] = self::DICA;

        return
            view('contents/header', $data).
            view('templates/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['titulo'] = "Editar template";
        $data['subtitulo'] = self::DICA;

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

        // validação
        $rules = [
            'nome' => 'required|max_length[100]',
            'assunto' => 'required|max_length[100]',
            'mensagem' => 'required|max_length[1000]',
            'id' => 'permit_empty|is_natural',
        ];
        
        $data = $this->request->getPost();

        if ( !$this->validateData($data, $rules) ) {
            return redirect()->back()->withInput();
        }

        $validData = $this->validator->getValidated();

        // sanitização
        if( isset($validData['id']) && empty($validData['id']) ) unset($validData['id']);
        $validData = esc($validData);

        $templatesModel = model(TemplatesModel::class);

        if( $templatesModel->salvaTemplate($validData) ) return redirect('templates');
        throw new Exception("Erro ao salvar template");

    }

    public function excluir($id)
    {
        $templatesModel = model(TemplatesModel::class);

        if( $templatesModel->removeTemplate($id) ) return redirect('templates');
        throw new Exception("Erro ao deletar template");

    }
}
