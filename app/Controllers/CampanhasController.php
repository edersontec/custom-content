<?php

namespace App\Controllers;

class CampanhasController extends BaseController
{
    public function index(): string
    {

        $table = new \CodeIgniter\View\Table();

        $data['title'] = "Campanhas";

        $campanhas = array(
                array('Name111', 'Color111', 'Size111'),
                array('Fred111', 'Blue111', 'Small111'),
                array('Mary111', 'Red111', 'Large111'),
                array('John111', 'Green111', 'Mediu111m')
        );
        $data['content'] = $table->generate($campanhas);

        return
            view('contents/header', $data).
            view('content', $data).
            view('contents/footer', $data);

    }
}
