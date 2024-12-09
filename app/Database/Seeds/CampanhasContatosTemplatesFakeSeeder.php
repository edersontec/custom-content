<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\CampanhasModel;
use App\Models\ContatosModel;
use App\Models\TemplatesModel;

class CampanhasContatosTemplatesSeeder extends Seeder
{

    const QTD_REGISTROS = 10;
    const QTD_MIN_CONTATOS_POR_CAMPANHA = 3;
    const QTD_MAX_CONTATOS_POR_CAMPANHA = 10;

    public function run()
    {
        
        $arrayCampanhas = model(CampanhasModel::class)->getCampanhas();
        $arrayContatos = model(ContatosModel::class)->getContatos();
        $arrayTemplates = model(TemplatesModel::class)->getTemplates();

        // preencher todas as campanhas
        foreach ($arrayCampanhas as $campanha) {

            //seleciona os contatos para a campanha
            shuffle($arrayContatos);
            $arrayContatosSelecionados = array_slice(
                $arrayContatos,
                0,
                min( rand(self::QTD_MIN_CONTATOS_POR_CAMPANHA, self::QTD_MAX_CONTATOS_POR_CAMPANHA), count($arrayContatos) )
            );

            //seleciona template para a campanha
            shuffle($arrayTemplates);
            $templateSelecionado = $arrayTemplates[0];

            foreach ($arrayContatosSelecionados as $contatoSelecionado) {
                $data = [
                    'campanhas_id' => $campanha['id'],
                    'contatos_id' => $contatoSelecionado['id'],
                    'templates_id' => $templateSelecionado['id']
                ];

                $this->db->table('campanhas_contatos_templates')->insert($data);
            }
        }
    }
}




