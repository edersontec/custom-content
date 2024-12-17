<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

use Config\Database;

use App\Models\ContatosModel;

use CodeIgniter\Exceptions\PageNotFoundException;

final class ContatosModelTest extends CIUnitTestCase
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

    private const ID_CONTATO_INEXISTENTE = 99999999999999999999999999;

    public function testDeveRetornarArrayComMultiplosContatosFakeSeeder(): void
    {
        $contatoModel = new ContatosModel();
        $arrayContatos = $contatoModel->getContatos();

        $expectedCount = 10;
        $this->assertCount($expectedCount, $arrayContatos);

    }

    public function testDeveRetornarApenasHumContatoFakeSeeder(): void
    {
        $expectedArrayContato = Array(
            'id' => 1,
            'nome' => 'Laura Marta Cordeiro Sobrinho',
            'email' => 'reinaldo77@example.com',
        );

        $contatoModel = new ContatosModel();
        $arrayContato = $contatoModel->getContato($expectedArrayContato['id']);

        $this->assertSame($expectedArrayContato,  $arrayContato);

    }

    public function testDeveExcluirEConfirmarExclusaoDeHumContatoFakeSeeder(): void
    {
        $expectedArrayContato = Array(
            'id' => 1,
            'nome' => 'Laura Marta Cordeiro Sobrinho',
            'email' => 'reinaldo77@example.com',
        );

        $contatoModel = new ContatosModel();
        $wasContatoExcluido = $contatoModel->removeContato($expectedArrayContato['id']);

        $this->assertTrue($wasContatoExcluido);

        $this->expectException(PageNotFoundException::class);
        $arrayContato = $contatoModel->getContato($expectedArrayContato['id']);

    }

    public function testDeveSalvarHumContatoFakeSeeder(): void
    {
        $expectedArrayContato = Array(
            'nome' => 'Laura Marta Cordeiro Sobrinho',
            'email' => 'reinaldo77@example.com',
        );

        $contatoModel = new ContatosModel();
        $wasContatoCriado = $contatoModel->salvaContato($expectedArrayContato);

        $this->assertTrue($wasContatoCriado);

        $db = Database::connect();
        $expectedArrayContato['id'] = $db->insertID();

        $contato = $contatoModel->getContato($expectedArrayContato['id']);

        $this->assertEquals($expectedArrayContato, $contato);

    }

    public function testDeveLancarPageNotFoundExceptionAoConsultarContatoInexistente(): void
    {
        $contatoModel = new ContatosModel();
        $this->expectException(PageNotFoundException::class);
        $contato = $contatoModel->getContato(self::ID_CONTATO_INEXISTENTE);

    }

    public function testDeveLancarPageNotFoundExceptionAoRemoverContatoInexistente(): void
    {
        $contatoModel = new ContatosModel();
        $this->expectException(PageNotFoundException::class);
        $contato = $contatoModel->removeContato(self::ID_CONTATO_INEXISTENTE);

    }


}
