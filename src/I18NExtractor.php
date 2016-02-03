<?php

namespace Maslosoft\AddendumI18NExtractor;

use Maslosoft\Addendum\Addendum;
use Maslosoft\Addendum\Utilities\AnnotationUtility;
use Maslosoft\AddendumI18NExtractor\Helpers\ClassContext;
use Maslosoft\MiniView\MiniView;

/**
 * This utility extract i18n labels, descriptions etc.
 * @codeCoverageIgnore
 * @author Piotr
 */
class I18NExtractor
{

	/**
	 * View Renderer
	 * @var MiniView
	 */
	public $view = null;
	private $file = [];
	private $searchPaths = [];

	public function __construct()
	{
		$this->view = new MiniView($this);
	}

	public function generate($searchPaths = [], $outputPath = null)
	{
		$this->searchPaths = $searchPaths;
		$this->file[] = '<?php';
		AnnotationUtility::fileWalker(Addendum::fly()->i18nAnnotations, [$this, 'walk'], $this->searchPaths);
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
		if (in_array($type, Addendum::fly()->i18nAnnotations))
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
