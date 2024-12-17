<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    private const DICA = "";

    public function index(): string
    {

        $data['titulo'] = "Home";
        $data['conteudo'] = "Seja bem vindo!";

        return
            view('contents/header', $data).
            view('home/content', $data).
            view('contents/footer', $data);
    }
}
