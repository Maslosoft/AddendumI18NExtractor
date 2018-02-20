<?php
namespace Extractor;

use Maslosoft\AddendumI18NExtractor\Helpers\AnnotationsExtractor;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\I18NExtractorModels\ModelInheriting;
use Maslosoft\I18NExtractorModels\ModelWithClassLabel;
use Maslosoft\I18NExtractorModels\ModelWithMultipleHints;
use Maslosoft\I18NExtractorModels\ModelWithTwoHints;
use ReflectionClass;

class ClassTest extends \Codeception\Test\Unit
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

    public function testExtractingOneMessagesFromClass()
    {
		$i18n = new I18NExtractor;
		$extractor = new AnnotationsExtractor($i18n);

		$path = (new ReflectionClass(ModelWithClassLabel::class))->getFileName();

		$messages = $extractor->getMessages($path);

		$this->assertNotEmpty($messages);
		$this->assertCount(1, $messages);
		$this->assertContains('Test', $messages);
    }

	public function testExtractingMultipleMessagesFromClass()
	{
		$i18n = new I18NExtractor;
		$extractor = new AnnotationsExtractor($i18n);

		$path = (new ReflectionClass(ModelWithTwoHints::class))->getFileName();

		$messages = $extractor->getMessages($path);

		$this->assertNotEmpty($messages);
		$this->assertCount(2, $messages);
		$this->assertContains('Hint 1', $messages);
		$this->assertContains('Hint 2', $messages);
	}

	public function testExtractingFromClassWithInheritance()
	{
		$i18n = new I18NExtractor;
		$extractor = new AnnotationsExtractor($i18n);

		$path = (new ReflectionClass(ModelInheriting::class))->getFileName();

		$messages = $extractor->getMessages($path);

		$this->assertNotEmpty($messages);
		$this->assertCount(4, $messages);
		$this->assertContains('Hint 1', $messages);
		$this->assertContains('Hint 2', $messages);
		$this->assertContains('Hint 3', $messages);
		$this->assertContains('Test', $messages);
	}
}