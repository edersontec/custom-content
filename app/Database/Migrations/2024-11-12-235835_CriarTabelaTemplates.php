<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaTemplates extends Migration
{
    public function up()
    {  

        $fields = [
            'id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unique' => true,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'TEXT',
                //'constraint' => '100',
                //'default' => '',
            ],
            'mensagem' => [
                'type' => 'TEXT',
                //'constraint' => 100,
                //'default' => '',
            ]
        ];

        $this->forge->addField($fields);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('templates');
    }

    public function down()
    {
        $this->forge->dropTable('templates');
    }
}

