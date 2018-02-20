<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 07:43
 */

namespace Maslosoft\AddendumI18NExtractor\Helpers;


use function basename;
use function get_class;
use function implode;
use Maslosoft\Addendum\Addendum;
use Maslosoft\Addendum\Reflection\ReflectionAnnotatedClass;
use Maslosoft\Addendum\Reflection\ReflectionAnnotatedMethod;
use Maslosoft\Addendum\Reflection\ReflectionAnnotatedProperty;
use Maslosoft\Addendum\Utilities\AnnotationUtility;
use Maslosoft\AddendumI18NExtractor\Annotations\DescriptionAnnotation;
use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use ReflectionClass;
use function sprintf;
use function str_replace;
use function vsprintf;

class AnnotationsExtractor
{
	const Method = 'method';
	const Field = 'field';

	/**
	 * Extractor instance
	 * @var I18NExtractor
	 */
	private $extractor;

	public function __construct(I18NExtractor $extractor)
	{
		$this->extractor = $extractor;
	}

	public function getMessages($file)
	{
		$annotations = AnnotationUtility::rawAnnotate($file);

		if(empty($annotations['className']))
		{
			return [];
		}

		$fqn = sprintf('%s\\%s', $annotations['namespace'], $annotations['className']);
		$addendum = Addendum::fly();
		$addendum->addNamespace(DescriptionAnnotation::Ns);
		$ra = new ReflectionAnnotatedClass($fqn, $addendum);

		;

		$messages = [];

		$allAnnotations = $ra->getAllAnnotations();

		foreach ($this->extract($allAnnotations, $ra->getShortName()) as $id => $value)
		{
			$messages[$id] = $value;
		}

		$data = [
			self::Method => [],
			self::Field => []
		];

		foreach($ra->getMethods() as $method)
		{
			/* @var $method ReflectionAnnotatedMethod */
			$data[self::Method][$method->name] = $method->getAllAnnotations();
		}

		foreach($ra->getProperties() as $property)
		{
			/* @var $property ReflectionAnnotatedProperty */
			$data[self::Field][$property->name] = $property->getAllAnnotations();
		}

		foreach ($data as $entityType => $annotationsSet)
		{
			foreach ($annotationsSet as $name => $allAnnotations)
			{
				$params = [
					$ra->getShortName(),
					$entityType,
					$name
				];
				$entityName = implode('_', $params);
				foreach ($this->extract($allAnnotations, $entityName) as $id => $value)
				{
					$messages[$id] = $value;
				}
			}
		}

		return $messages;
	}

	public function extract($annotations, $name)
	{
		$i = 0;
		foreach($annotations as $annotationInstance)
		{
			$type = preg_replace('~Annotation$~', '', (new ReflectionClass($annotationInstance))->getShortName());
			if (in_array($type, $this->extractor->i18nAnnotations))
			{
				$i++;

				$value = (string) $annotationInstance;

				// Some annotations can be defined multiple times,
				// so add integer value to name
				$params = [
					$name,
					$i
				];
				$id = implode('_', $params);
				yield $id => $value;
			}
		}
	}
}