<?php

namespace Extractor;

use Codeception\Test\Unit;
use Maslosoft\AddendumI18NExtractor\Helpers\AnnotationsExtractor;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\I18NExtractorModels\ModelWithTrait;
use ReflectionClass;

class TraitsTest extends Unit
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

	// tests
	public function testTraitsExtraction()
	{
		$i18n = new I18NExtractor;
		$extractor = new AnnotationsExtractor($i18n);

		$path = (new ReflectionClass(ModelWithTrait::class))->getFileName();

		$messages = $extractor->getMessages($path);

		$this->assertNotEmpty($messages);
		$this->assertCount(2, $messages);

		$this->assertContains('Title', $messages);
		$this->assertContains('Keywords', $messages);
	}
}