<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

use CodeIgniter\CLI\CLI;

final class ContatosControllerTest extends CIUnitTestCase
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

    public function testDeveExibirIDdoContatoNoDomNoFormularioDeEdicao(): void
    {

        $result = $this->call('get', 'contatos/editar/2');
        $expectedDom = '<input type="hidden" name="id" value="2">';

        // CLI::write( print_r($result->getBody(), true) );
        
        $this->assertTrue( $result->see($expectedDom) );

    }

}