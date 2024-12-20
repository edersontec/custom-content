<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

use Config\Database;

use App\Models\CampanhasModel;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Database\Exceptions\DatabaseException;

final class CampanhasModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    // For Seeds
    protected $seedOnce = false;
    protected $seed     = ['TestSeeder', 'AppDataSeeder'];
    protected $basePath = 'app/Database';

    private const ID_CAMPANHA_INEXISTENTE = 99999999999999999999999999;

    public function testDeveRetornarArrayComMultiplosCampanhasFakeSeeder(): void
    {
        $campanhasModel = new CampanhasModel();
        $arrayCampanhas = $campanhasModel->getCampanhas();

        $expectedCount = 5;
        $this->assertCount($expectedCount, $arrayCampanhas);

    }

    public function testDeveRetornarApenasHumCampanhaFakeSeeder(): void
    {
        $expectedArrayCampanha = Array(
            'id' => 1,
            'nome' => 'Campanha #0 - consequatur',
            'data_criacao' => '1997-05-07 09:03:59',
            'campanhas_status_id' => 0,
            'contatosSelecionados' => [],
            'idsContatosSelecionados' => [],
            'templatesSelecionados' => [],
            'idsTemplatesSelecionados' => [],
        );

        $campanhasModel = new CampanhasModel();
        $arrayCampanha = $campanhasModel->getCampanha($expectedArrayCampanha['id']);

        $this->assertEquals( array_keys($expectedArrayCampanha), array_keys($arrayCampanha) );

    }

    public function testDeveExcluirEConfirmarExclusaoDeHumCampanhaFakeSeeder(): void
    {
        $expectedArrayCampanha = Array(
            'id' => 1,
            'nome' => 'Campanha #0 - consequatur',
            'data_criacao' => '1997-05-07 09:03:59',
            'campanhas_status_id' => 0,
            'idsContatosSelecionados' => [],
            'idsTemplatesSelecionados' => [],
        );

        $campanhasModel = new CampanhasModel();
        $wasCampanhaExcluido = $campanhasModel->removeCampanha($expectedArrayCampanha['id']);

        $this->assertTrue($wasCampanhaExcluido);

        $this->expectException(PageNotFoundException::class);
        $arrayCampanha = $campanhasModel->getCampanha($expectedArrayCampanha['id']);

    }

    public function testDeveSalvarHumCampanhaFakeSeeder(): void
    {
        $expectedArrayCampanha = Array(
            'nome' => 'Campanha #9999 - consequatur',
            'data_criacao' => '1997-05-07 09:03:59',
            'campanhas_status_id' => 0,
            'idsContatosSelecionados' => [1, 2],
            'idsTemplatesSelecionados' => [1],
        );

        $campanhasModel = new CampanhasModel();
        $wasCampanhaCriada = $campanhasModel->salvaCampanha($expectedArrayCampanha);

        $this->assertTrue($wasCampanhaCriada);

        $db = Database::connect();
        // quero ultima ID da tabela 'campanhas', porém nao posso usar $db->insertID() aqui pois o ultimo insert foi na tabela N:N 'campanhas_contatos_templates'
        $lastInsertId = $db->query('SELECT max(id) as maxid FROM campanhas')->getResultArray()[0]['maxid'];
        $expectedArrayCampanha['id'] = $lastInsertId;

        $campanha = $campanhasModel->getCampanha($expectedArrayCampanha['id']);

        $this->assertEquals($expectedArrayCampanha['nome'], $campanha['nome']);

    }

    public function testDeveLancarDatabaseExceptionAoInserirForeignKeyInexistente(): void
    {
        $expectedArrayCampanha = Array(
            'nome' => 'Campanha #9999 - consequatur',
            'data_criacao' => '1997-05-07 09:03:59',
            'campanhas_status_id' => 0,
            'idsContatosSelecionados' => [5000, 9999],
            'idsTemplatesSelecionados' => [1],
        );
        
        $this->expectException(DatabaseException::class);
        
        $campanhasModel = new CampanhasModel();
        $wasCampanhaCriada = $campanhasModel->salvaCampanha($expectedArrayCampanha);

    }

    public function testDeveLancarPageNotFoundExceptionAoConsultarCampanhaInexistente(): void
    {
        $campanhaModel = new CampanhasModel();
        $this->expectException(PageNotFoundException::class);
        $campanha = $campanhaModel->getCampanha(self::ID_CAMPANHA_INEXISTENTE);

    }
    
    public function testDeveLancarPageNotFoundExceptionAoRemoverCampanhaInexistente(): void
    {
        $campanhaModel = new CampanhasModel();
        $this->expectException(PageNotFoundException::class);
        $campanha = $campanhaModel->removeCampanha(self::ID_CAMPANHA_INEXISTENTE);
        
    }

    public function testDeveLancarPageNotFoundExceptionAoExecutarCampanhaInexistente(): void
    {
        $campanhaModel = new CampanhasModel();
        $this->expectException(PageNotFoundException::class);
        $campanha = $campanhaModel->executaCampanha(self::ID_CAMPANHA_INEXISTENTE);

    }


}
