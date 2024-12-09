<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CampanhasStatusPresetSeeder extends Seeder
{

    public function run()
    {

        // insere informações pre-definidas

        $data = [
            [
                'id' => 0,
                'nome' => 'Não Executado'
            ],
            [
                'id' => 1,
                'nome' => 'Em Execução'
            ],
            [
                'id' => 2,
                'nome' => 'Finalizado com Sucesso'
            ],
            [
                'id' => 3,
                'nome' => 'Erro'
            ]
        ];
                
        $this->db->table('campanhas_status')->insertBatch($data);
    }
}


