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

}