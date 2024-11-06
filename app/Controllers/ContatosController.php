<?php

namespace App\Controllers;

use App\Models\ContatosModel;

class ContatosController extends BaseController
{
    public function index(): string
    {

        $data['title'] = "Contatos";

        $data['btn_novo_contato'] = '<a href="/contatos/novo">[novo contato]</a>';

        $contatosModel = model(ContatosModel::class);
        $contatos = $contatosModel->getContatos();

        //Adiciona botões CRUD em cada contato
        foreach ($contatos as $key => $contato) {
            $contatos[$key]['link_editar'] = '<a href="/contatos/editar/"'.$contato['id'].'">editar</a>';
            $contatos[$key]['link_excluir'] = '<a href="/contatos/excluir/"'.$contato['id'].'">excluir</a>';  
        }

        $table = new \CodeIgniter\View\Table();
        $table->setHeading('ID', 'Nome', 'Email');
        $data['content'] = $table->generate($contatos);

        return
            view('contents/header', $data).
            view('contatos/content', $data).
            view('contents/footer', $data);

    }

    public function novo(): string
    {

        $data['title'] = "Cadastrar Novo Contato";

        return
            view('contents/header', $data).
            view('contatos/form', $data).
            view('contents/footer', $data);
    }

    public function editar($id): string
    {

        $data['title'] = "Editar Contato";

        $contatosModel = model(ContatosModel::class);
        $arrayDetalhesContato = $contatosModel->getContato($id);

        $data = array_merge($data, $arrayDetalhesContato);

        return
            view('contents/header', $data).
            view('contatos/form', $data).
            view('contents/footer', $data);
    }


    public function salvar(){

        $data = $this->request->getPost();

        if( empty($data) || in_array("", $data) ) return redirect()->back();

        //print_r($data); dd();

        $contatosModel = model(ContatosModel::class);
        
        // save() = insert() or update()
        $contatosModel->save($data);

        return redirect('contatos');

    }

    public function excluir($id)
    {
        $contatosModel = model(ContatosModel::class);

        if( $contatosModel->removeContato($id) ) return redirect('contatos');
        throw new Exception("Erro ao deletar");

    }
}
