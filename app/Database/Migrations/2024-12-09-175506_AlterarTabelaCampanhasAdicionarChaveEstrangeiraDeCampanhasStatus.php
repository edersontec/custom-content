<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterarTabelaCampanhasAdicionarChaveEstrangeiraDeCampanhasStatus extends Migration
{
    public function up()
    {
        $fields = [
            'campanhas_status_id' => [
                'type' => 'INTEGER',
                //'constraint' => 5,
                'unsigned' => true,
                'default' => 0
            ]
        ];
        $this->forge->addColumn('campanhas', $fields);

        $this->forge->addForeignKey('campanhas_status_id', 'campanhas_status', 'id');
    }

    public function down()
    {
        $this->forge->dropColumn('campanhas', 'campanhas_status_id');
    }
}
