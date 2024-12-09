<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppDataSeeder extends Seeder
{
    public function run()
    {
        $this->call('CampanhasStatusPresetSeeder');

    }
}
