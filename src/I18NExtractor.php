<?php

/**
 * This software package is licensed under `BSD-3-Clause` license[s].
 *
 * @package maslosoft/addendum-i18n-extractor
 * @license BSD-3-Clause
 *
 * @copyright Copyright (c) Peter Maselkowski <peter@maslosoft.com>
 * @link https://maslosoft.com/
 */

namespace Maslosoft\AddendumI18NExtractor;

use Maslosoft\Addendum\Addendum;
use Maslosoft\Addendum\Utilities\AnnotationUtility;
use Maslosoft\AddendumI18NExtractor\Helpers\ClassContext;
use Maslosoft\Cli\Shared\ConfigReader;
use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;

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

	public function __construct($configName = self::ConfigName)
	{
		$this->view = new MiniView($this);

		$config = new ConfigReader($configName);
		$this->di = EmbeDi::fly($configName);
		$this->di->configure($this);
		$this->di->apply($config->toArray(), $this);

	}

	public function generate($searchPaths = [], $outputPath = null)
	{
		$this->searchPaths = $searchPaths;
		$this->file[] = '<?php';
		AnnotationUtility::fileWalker($this->i18nAnnotations, [$this, 'walk'], $this->searchPaths);
		if (null === $outputPath)
		{
			$outputPath = 'autogen';
		}
		$err = error_reporting(E_ERROR);
		$mask = umask(0);
		mkdir($outputPath, 0777, true);
		umask($mask);
		error_reporting($err);
		file_put_contents(sprintf('%s/annotated-labels.php', $outputPath), implode("\n", $this->file));
		return $this->file;
	}

	public function walk($file)
	{
		$annotations = AnnotationUtility::rawAnnotate($file);
		foreach ($annotations['class'] as $type => $annotation)
		{
			$this->extract($type, $annotation, $file);
		}

		foreach (['methods', 'fields'] as $entityType)
		{
			foreach ($annotations[$entityType] as $name => $entity)
			{
				foreach ($entity as $type => $annotation)
				{
					$this->extract($type, $annotation, $file, $name);
				}
			}
		}
	}

	public function extract($type, $annotation, $file, $name = null)
	{
		$context = ClassContext::create($file, $this->searchPaths);
		if (in_array($type, $this->i18nAnnotations))
		{
			foreach ($annotation as $values)
			{
				if (!isset($values['value']))
				{
					continue;
				}
				$value = $values['value'];
				if (!$value)
				{
					continue;
				}
				$alias = basename($file);
				$parts = explode('.', $alias);
				array_pop($parts);
				$class = array_pop($parts);
				if (null === $name)
				{
					$name = $class;
				}
				$w = "'";
				if (strstr($value, "'") !== false)
				{
					$w = '"';
				}
				$this->file[] = $this->view->render('i18nEntity', [
					'alias' => $alias,
					'class' => $class,
					'name' => $name,
					'value' => $value,
					'context' => $context,
					'w' => $w
						], true);
			}
		}
	}

}
