<?php

/**
 * This software package is licensed under `BSD-3-Clause` license[s].
 *
 * @package   maslosoft/addendum-i18n-extractor
 * @license   BSD-3-Clause
 *
 * @copyright Copyright (c) Peter Maselkowski <peter@maslosoft.com>
 * @link      https://maslosoft.com/
 */

namespace Maslosoft\AddendumI18NExtractor;

use function dirname;
use function file_exists;
use function is_array;
use function is_dir;
use function is_writable;
use Maslosoft\Addendum\Addendum;
use Maslosoft\Addendum\Utilities\AnnotationUtility;
use Maslosoft\AddendumI18NExtractor\Helpers\AnnotationsExtractor;
use Maslosoft\AddendumI18NExtractor\Helpers\ClassContext;
use Maslosoft\AddendumI18NExtractor\Helpers\MessageRenderer;
use Maslosoft\Cli\Shared\ConfigReader;
use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use const PHP_EOL;
use UnexpectedValueException;
use function var_dump;

/**
 * This utility extract i18n labels, descriptions etc.
 * @codeCoverageIgnore
 * @author Piotr
 */
class I18NExtractor
{

	/**
	 * Config file name
	 */
	const ConfigName = "i18n-extractor";

	/**
	 * View Renderer
	 * @var MiniView
	 */
	public $view = null;

	public $i18nAnnotations = [
		'Label',
		'Description',
		'Hint'
	];

	private $file = [];

	private $searchPaths = [];

	/**
	 * @var AnnotationsExtractor
	 */
	private $extractor = null;

	/**
	 * @var MessageRenderer
	 */
	private $renderer = null;

	public function __construct($configName = self::ConfigName)
	{
		$this->view = new MiniView($this);

		$config = new ConfigReader($configName);
		$this->di = EmbeDi::fly($configName);
		$this->di->configure($this);
		$this->di->apply($config->toArray(), $this);

		// Make sure that it is instantiated
		// *after* applying configuration
		$this->extractor = new AnnotationsExtractor($this);
		$this->renderer = new MessageRenderer($this);
	}

	public function generate($searchPaths = [], $outputPath = null)
	{
		$this->searchPaths = $searchPaths;
		$this->file[] = '<?php';

		if (null === $outputPath)
		{
			$outputPath = 'generated';
		}
		if(!file_exists($outputPath) && is_writable(dirname($outputPath)))
		{
			$mask = umask(0);
			mkdir($outputPath, 0777, true);
			umask($mask);
		}

		if(!is_dir($outputPath))
		{
			throw new UnexpectedValueException("Dir $outputPath does not exists and could not be created");
		}

		if(!is_writable($outputPath))
		{
			throw new UnexpectedValueException("Dir $outputPath is not writable");
		}

		AnnotationUtility::fileWalker($this->i18nAnnotations, [$this, 'walk'], $this->searchPaths);
		$path = sprintf('%s/annotated-labels.php', $outputPath);
		file_put_contents($path, implode("\n", $this->file));
		return $this->file;
	}

	public function walk($file)
	{
		foreach ($this->extractor->getMessages($file) as $name => $message)
		{
			$this->extract($file, $name, $message);
		}
	}

	public function extract($file, $name, $message)
	{
		$this->file[] = $this->renderer->render($file, $name, $message);
	}

}
