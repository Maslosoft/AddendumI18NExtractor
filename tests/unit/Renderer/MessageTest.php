<?php
namespace Renderer;

use function codecept_debug;
use Maslosoft\AddendumI18NExtractor\Helpers\MessageRenderer;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\I18NExtractorModels\ModelWithClassLabel;
use ReflectionClass;

class MessageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
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
		$this->assertContains('Test', $message);
		$this->assertContains('$varName', $message);
	}
}