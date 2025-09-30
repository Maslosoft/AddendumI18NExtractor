<?php
namespace Renderer;

use Codeception\Test\Unit;
use UnitTester;
use function codecept_debug;
use Maslosoft\AddendumI18NExtractor\Helpers\MessageRenderer;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\I18NExtractorModels\ModelWithClassLabel;
use ReflectionClass;

class MessageTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

	public function testRenderingOneMessageFromClass()
	{
		$i18n = new I18NExtractor;
		$renderer = new MessageRenderer($i18n);

		$path = (new ReflectionClass(ModelWithClassLabel::class))->getFileName();

		$message = $renderer->render($path, 'varName','Test');

		codecept_debug($message);

		$this->assertNotEmpty($message);
		$this->assertStringContainsString('Test', $message);
		$this->assertStringContainsString('$varName', $message);
	}
}