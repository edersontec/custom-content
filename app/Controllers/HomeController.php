<?php

namespace App\Controllers;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

class HomeController extends BaseController
{
    private const DICA = "";

    public function index(): string
    {

        $data['hasIcones'] = true;

        $data['titulo'] = "Home";
        $data['conteudo'] = "";

        $data['total_registros']['campanhas'] = model(CampanhasModel::class)->getQuantCampanhas();
        $data['total_registros']['contatos'] = model(ContatosModel::class)->getQuantContatos();
        $data['total_registros']['templates'] = model(TemplatesModel::class)->getQuantTemplates();

        return
            view('contents/header', $data).
            view('home/content', $data).
            view('contents/footer', $data);
    }

}
