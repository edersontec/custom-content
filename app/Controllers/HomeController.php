<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {

        $data['title'] = "Home";
        $data['content'] = "Seja bem vindo!";

        return
            view('contents/header', $data).
            view('home/content', $data).
            view('contents/footer', $data);
    }
}