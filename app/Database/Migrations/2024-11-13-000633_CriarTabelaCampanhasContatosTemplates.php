<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaCampanhasContatosTemplates extends Migration
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
            'campanhas_id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unsigned' => true,
            ],
            'contatos_id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unsigned' => true,
            ],
            'templates_id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unsigned' => true,
            ]
        ];

        $this->forge->addField($fields);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('campanhas_id', 'campanhas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('contatos_id', 'contatos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('templates_id', 'templates', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('campanhas_contatos_templates');
    }

    public function down()
    {
        $this->forge->dropTable('campanhas_contatos_templates');
    }
}

