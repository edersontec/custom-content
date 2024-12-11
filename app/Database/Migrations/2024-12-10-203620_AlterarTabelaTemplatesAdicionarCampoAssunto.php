<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterarTabelaTemplatesAdicionarCampoAssunto extends Migration
{
    public function up()
    {
        $fields = [
            'assunto' => [
                'type' => 'TEXT',
                //'constraint' => '100',
                //'default' => '',
                'after' => 'nome'
            ]
        ];
        $this->forge->addColumn('templates', $fields);

        // Clona os dados da coluna 'nome' para a coluna 'assunto' se estiver NULL
        $this->db->query("UPDATE templates SET assunto = nome WHERE (nome IS NOT NULL AND assunto IS NULL);");

    }

    public function down()
    {
        $this->forge->dropColumn('templates', 'assunto');
    }
}
