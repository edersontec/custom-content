<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

use CodeIgniter\CLI\CLI;

final class TemplatesControllerTest extends CIUnitTestCase
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

    public function testDeveExibirIDdoTemplateNoDomNoFormularioDeEdicao(): void
    {

        $result = $this->call('get', 'templates/editar/2');
        $expectedDom = '<input type="hidden" name="id" value="2">';

        // CLI::write( print_r($result->getBody(), true) );
        
        $this->assertTrue( $result->see($expectedDom) );

    }

    public function testDeveConseguirAcessarRotasDeTemplatesComSucesso(): void
    {
        
        $expectedDom = '<h1>Templates</h1>';
        $result = $this->call('get', '/templates');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );
        
        $expectedDom = '<h1>Cadastrar novo template</h1>';
        $result = $this->call('get', '/templates/novo');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );

        $expectedDom = '<h1>Editar template</h1>';
        $result = $this->call('get', '/templates/editar/1');
        // CLI::write( print_r($result->getBody(), true) );
        $this->assertTrue( $result->see($expectedDom) );
        
        // Esta rota não retorna status 200 diretamente porque processa e depois redireciona para uma view.
        // Não encontrei no Codeigniter uma forma de usar FOLLOWLOCATION durante teste diretamente no Controller.
        $expectedStatus = 302;
        $result = $this->call('post', '/templates/salvar');
        $result->assertStatus($expectedStatus);

        // Esta rota não retorna status 200 diretamente porque processa e depois redireciona para uma view.
        // Não encontrei no Codeigniter uma forma de usar FOLLOWLOCATION durante teste diretamente no Controller.
        $expectedStatus = 302;
        $result = $this->call('get', '/templates/excluir/1');
        $result->assertStatus($expectedStatus);

    }

}