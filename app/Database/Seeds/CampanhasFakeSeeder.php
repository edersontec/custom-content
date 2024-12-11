<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CampanhasFakeSeeder extends Seeder
{

    const QTD_REGISTROS = 5;

    const IS_OBTER_SEMPRE_MESMOS_DADOS = true;
    const NUMERO_SEED = 1234;

    public function run()
    {

        $faker = \Faker\Factory::create('pt_BR');
        if(self::IS_OBTER_SEMPRE_MESMOS_DADOS) $faker->seed(self::NUMERO_SEED);

        for ($i = 0; $i < self::QTD_REGISTROS; $i++) {
        
            $data = [
                'nome' => "Campanha #$i - " . $faker->word(),
                'data_criacao' => $faker->date() . " " . $faker->time(),
            ];

            $this->db->table('campanhas')->insert($data);

        }
    }
}

