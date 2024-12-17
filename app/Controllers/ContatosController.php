<?php

namespace App\Controllers;

use App\Models\ContatosModel;
use CodeIgniter\View\Table;

class ContatosController extends BaseController
{
    private const DICA = "Um contato é uma pessoa ou empresa com a qual você deseja enviar mensagens personalizadas";

    protected $helpers = ['form'];

    public function index(): string
    {

        $data['titulo'] = "Contatos";
        $data['subtitulo'] = self::DICA;

        $contatosModel = model(ContatosModel::class);
        $contatos = $contatosModel->getContatos();

        foreach ($contatos as $key => $contato) {
            
            //Adiciona botões CRUD em cada contato
            $contatos[$key]['link_editar'] = '<a href="/contatos/editar/'.$contato['id'].'">editar</a>';
            $contatos[$key]['link_excluir'] = '<a href="/contatos/excluir/'.$contato['id'].'">excluir</a>';  
        }

        $table = new Table();

        $arrayHeader = array_key_exists(0, $contatos) ? array_keys($contatos[0]) : "";
        $table->setHeading($arrayHeader);

        $data['conteudo'] = $table->generate($contatos);

        return
            view('contents/header', $data).
            view('contatos/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['titulo'] = "Cadastrar novo contato";
        $data['subtitulo'] = self::DICA;

        return
            view('contents/header', $data).
            view('contatos/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['titulo'] = "Editar contato";
        $data['subtitulo'] = self::DICA;

        $contatosModel = model(ContatosModel::class);
        $arrayDetalhesContato = $contatosModel->getContato($id);

        $data = array_merge($data, $arrayDetalhesContato);

        return
            view('contents/header', $data).
            view('contatos/form', $data).
            view('contents/footer', $data);
    }

    public function salvar()
    {

        // validação
        $rules = [
            'nome' => 'required|max_length[100]',
            'email' => 'required|max_length[100]|valid_email',
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

        $contatosModel = model(ContatosModel::class);

        if( $contatosModel->salvaContato($validData) ) return redirect('contatos');
        throw new Exception("Erro ao salvar contato");

    }

    public function excluir($id)
    {
        $contatosModel = model(ContatosModel::class);

        if( $contatosModel->removeContato($id) ) return redirect('contatos');
        throw new Exception("Erro ao deletar contato");

    }
}
