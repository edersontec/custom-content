<?php

namespace App\Controllers;

class TemplatesController extends BaseController
{
    public function index(): string
    {

        $table = new \CodeIgniter\View\Table();

        $data['title'] = "Templates";

        $templates = array(
                array('Name', 'Color', 'Size'),
                array('Fred', 'Blue', 'Small'),
                array('Mary', 'Red', 'Large'),
                array('John', 'Green', 'Medium')
        );
        $data['content'] = $table->generate($templates);

        return
            view('templates/header', $data).
            view('content', $data).
            view('templates/footer', $data);


    }
}
