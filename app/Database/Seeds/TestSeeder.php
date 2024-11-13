<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->call('ContatosSeeder');
        $this->call('TemplatesSeeder');
        $this->call('CampanhasSeeder');
        $this->call('CampanhasContatosTemplatesSeeder');

    }
}
