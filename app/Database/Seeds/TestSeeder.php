<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->call('ContatosFakeSeeder');
        $this->call('TemplatesFakeSeeder');
        $this->call('CampanhasFakeSeeder');
        $this->call('CampanhasContatosTemplatesFakeSeeder');

    }
}
