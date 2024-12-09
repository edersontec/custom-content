<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaCampanhaStatus extends Migration
{
    public function up()
    {  

        $fields = [
            'id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unique' => true,
                'unsigned' => true,
            ],
            'nome' => [
                'type' => 'TEXT',
                //'constraint' => '100',
                //'default' => '',
            ]
        ];

        $this->forge->addField($fields);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('campanhas_status');

    }

    public function down()
    {
        $this->forge->dropTable('campanhas_status');
    }
}
