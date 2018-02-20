<?php
namespace Extractor;

use Maslosoft\AddendumI18NExtractor\Helpers\AnnotationsExtractor;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\I18NExtractorModels\ModelWithMethod;
use ReflectionClass;

class MethodTest extends \Codeception\Test\Unit
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

	public function testExtractingOneMessagesFromMethod()
	{
		$i18n = new I18NExtractor;
		$extractor = new AnnotationsExtractor($i18n);

		$path = (new ReflectionClass(ModelWithMethod::class))->getFileName();

		$messages = $extractor->getMessages($path);

		$this->assertNotEmpty($messages);
		$this->assertCount(1, $messages);
		$this->assertContains('Test', $messages);
	}
}