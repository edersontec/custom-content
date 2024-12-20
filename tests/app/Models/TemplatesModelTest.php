<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

use Config\Database;

use App\Models\TemplatesModel;

use CodeIgniter\Exceptions\PageNotFoundException;

final class TemplatesModelTest extends CIUnitTestCase
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

    private const ID_TEMPLATE_INEXISTENTE = 99999999999999999999999999;

    public function testDeveRetornarArrayComMultiplosTemplatesFakeSeeder(): void
    {
        $templatesModel = new TemplatesModel();
        $arrayTemplates = $templatesModel->getTemplates();

        $expectedCount = 3;
        $this->assertCount($expectedCount, $arrayTemplates);

    }

    public function testDeveRetornarApenasHumTemplateFakeSeeder(): void
    {
        $expectedArrayTemplate = Array(
            'id' => 1,
            'nome' => 'Mensagem desejando uma boa semana',
            'mensagem' => 'Olá {nome},...',
            'assunto' => 'Tenha uma ótima semana {nome}!',
        );

        $templatesModel = new TemplatesModel();
        $arrayTemplate = $templatesModel->getTemplate($expectedArrayTemplate['id']);

        // assertEqualsCanonicalizing: faz um sort nos arrays antes da comparação
        $this->assertEqualsCanonicalizing( array_keys($expectedArrayTemplate),  array_keys($arrayTemplate) );

    }

    public function testDeveExcluirEConfirmarExclusaoDeHumTemplateFakeSeeder(): void
    {
        $expectedArrayTemplate = Array(
            'id' => 1,
            'nome' => 'Mensagem desejando uma boa semana',
            'mensagem' => 'Olá {nome},...',
            'assunto' => 'Tenha uma ótima semana {nome}!',
        );

        $templatesModel = new TemplatesModel();
        $wasTemplateExcluido = $templatesModel->removeTemplate($expectedArrayTemplate['id']);

        $this->assertTrue($wasTemplateExcluido);

        $this->expectException(PageNotFoundException::class);
        $arrayTemplate = $templatesModel->getTemplate($expectedArrayTemplate['id']);

    }

    public function testDeveSalvarHumTemplateFakeSeeder(): void
    {
        $expectedArrayTemplate = Array(
            'nome' => 'Mensagem desejando uma boa semana',
            'mensagem' => 'Olá {nome},...',
            'assunto' => 'Tenha uma ótima semana {nome}!',
        );

        $templatesModel = new TemplatesModel();
        $wasTemplateCriado = $templatesModel->salvaTemplate($expectedArrayTemplate);

        $this->assertTrue($wasTemplateCriado);

        $db = Database::connect();
        $expectedArrayTemplate['id'] = $db->insertID();

        $template = $templatesModel->getTemplate($expectedArrayTemplate['id']);

        $this->assertEquals($expectedArrayTemplate, $template);
        
    }

    public function testDeveLancarPageNotFoundExceptionAoConsultarTemplateInexistente(): void
    {
        $templatesModel = new TemplatesModel();
        $this->expectException(PageNotFoundException::class);
        $template = $templatesModel->getTemplate(self::ID_TEMPLATE_INEXISTENTE);

    }

    public function testDeveLancarPageNotFoundExceptionAoRemoverTemplateInexistente(): void
    {
        $templatesModel = new TemplatesModel();
        $this->expectException(PageNotFoundException::class);
        $template = $templatesModel->removeTemplate(self::ID_TEMPLATE_INEXISTENTE);

    }


}
