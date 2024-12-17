<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

use CodeIgniter\CLI\CLI;

final class CampanhasControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    // For Seeds
    protected $seedOnce = false;
    protected $seed     = ['TestSeeder', 'AppDataSeeder'];
    protected $basePath = 'app/Database';

    public function testDeveExibirIDDaCampanhaNoDomNoFormularioDeEdicao(): void
    {

        $result = $this->call('get', 'campanhas/editar/2');
        $expectedDom = '<input type="hidden" name="id" value="2">';

        // CLI::write( print_r($result->getBody(), true) );
        
        $this->assertTrue( $result->see($expectedDom) );

    }

    public function testDeveConseguirAcessarRotasDeCampanhasComSucesso(): void
    {
        
        $expectedDom = '<h1>Campanhas</h1>';
        $result = $this->call('get', '/campanhas');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );
        
        $expectedDom = '<h1>Cadastrar nova campanha</h1>';
        $result = $this->call('get', '/campanhas/novo');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );

        $expectedDom = '<h1>Editar campanha</h1>';
        $result = $this->call('get', '/campanhas/editar/1');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );
        
        // Esta rota não retorna status 200 diretamente porque processa e depois redireciona para uma view.
        // Não encontrei no Codeigniter uma forma de usar FOLLOWLOCATION durante teste diretamente no Controller.
        $expectedStatus = 302;
        $result = $this->call('post', '/campanhas/salvar');
        $result->assertStatus($expectedStatus);
        
        // Esta rota não retorna status 200 diretamente porque processa e depois redireciona para uma view.
        // Não encontrei no Codeigniter uma forma de usar FOLLOWLOCATION durante teste diretamente no Controller.
        $expectedStatus = 302;
        $result = $this->call('get', '/campanhas/executar/1');
        $result->assertStatus($expectedStatus);

        // Esta rota não retorna status 200 diretamente porque processa e depois redireciona para uma view.
        // Não encontrei no Codeigniter uma forma de usar FOLLOWLOCATION durante teste diretamente no Controller.
        $expectedStatus = 302;
        $result = $this->call('get', '/campanhas/excluir/1');
        $result->assertStatus($expectedStatus);

    }

}