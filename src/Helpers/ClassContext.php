<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\AddendumI18NExtractor\Helpers;

use Maslosoft\Addendum\Builder\DocComment;

/**
 * Context
 * @deprecated see Maslosoft\Components\I18N\ClassContext
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ClassContext
{

	/**
	 * Create context for class, based on file name containing this class.
	 *
	 * NOTE: File must contain only one class, or it will fail or produce unpredictible results.
	 *
	 * @param string $file
	 * @return string
	 */
	public static function create($file)
	{
		$doc = new DocComment();
		$docData = $doc->forFile($file);
		
		// No class in file
		if(empty($docData['namespace']))
		{
			return '';
		}
		$className = sprintf('%s\\%s', $docData['namespace'], $docData['className']);
		return self::fromClass($className);
	}

	/**
	 * Get translation context from class name.
	 *
	 * @param string|object $className
	 * @return string
	 */
	public static function fromClass($className)
	{
		// In case it's object, get it's name
		if (is_object($className))
		{
			$className = get_class($className);
		}
		// Trim out any remaining slashes
		$className = trim($className, '\\');

		// Convert to dots
		$className = str_replace('\\', '.', $className);

		// Get last 3 parts of a class name
		$parts = explode('.', $className);
		if (count($parts) > 3)
		{
			$parts = array_slice($parts, -3, 3);
		}
		$context = implode('.', $parts);

		return $context;
	}

}
