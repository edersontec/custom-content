<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\CLI\CLI;

class EmailController extends BaseController
{
    public function index()
    {
        //
    }


    public function testarEnvioEmail()
    {

        // método para validar se serviço de email SMTP está funcionando corretamente

        $emailDestinatario = CLI::prompt('Digite email do destinatário', null, 'required|valid_email'); 

        $email = service('email');
        $email->clear();

        $email->setTo($emailDestinatario);
        $email->setSubject('Custom Content - Email de teste');
        $email->setMessage('Este é um email de teste enviado para ' . $emailDestinatario);



        CLI::write('-- Executar enviar email', 'yellow', 'black');
        $wasEmailEnviado = $email->send(false);
        CLI::newLine();



        CLI::write('-- Resultado envio email', 'yellow', 'black');
        if ($wasEmailEnviado) {
            CLI::write('Email enviado com sucesso!', 'green', 'black');
        }else{
            CLI::error('E-mail não foi enviado');
        }
        CLI::newLine();



        CLI::write('-- Dados Debugger', 'yellow', 'black');
        CLI::write(
            print_r( $email->printDebugger() )
        );
        CLI::newLine();


    }

}
