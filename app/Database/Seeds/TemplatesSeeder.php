<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TemplatesSeeder extends Seeder
{

    public function run()
    {

        $array[] = [

            'nome' => "Mensagem desejando uma boa semana",
            'mensagem' => 
                "Olá {{nome}},\n\nQue esta semana seja incrível!\n\nAtenciosamente,\nEmpresa ABC",
        ];

        $array[] = [
            
            'nome' => "Lembrete de vencimento",
            'mensagem' => 
                "Olá {{nome}},\n\nVenho lembrar que sua conta vence este mês.\nEstou a disposição para quaisquer esclarecimentos.\n\nAtenciosamente,\nEmpreza XYZ",
        ];


        $array[] = [
            
            'nome' => "Promoção do mês",
            'mensagem' => 
                "Olá {{nome}},\n\nVeja as ofertas que preparamos para você em https://www.example.com\n\nAtenciosamente,\nEmpresa JKL",
        ];

        foreach ($array as $data) {

            $this->db->table('templates')->insert($data);

        }
    }
}
