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

namespace Maslosoft\AddendumI18NExtractor\Helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * FileWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class FileWalker
{

	/**
	 * This utility method find php files and perform callback if file is readable possible
	 *
	 * Example callback function signature:
	 *
	 * ```php
	 * function myCallback($file, $contents)
	 * {
	 * 		// Do something
	 * }
	 * ```
	 *
	 * @param callback $callback
	 */
	public static function scan($callback, $searchPaths = [])
	{
		foreach ($searchPaths as $path)
		{
			$directoryIterator = new RecursiveDirectoryIterator($path);
			$iterator = new RecursiveIteratorIterator($directoryIterator);
			$regexIterator = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
			foreach ($regexIterator as $matches)
			{
				$file = $matches[0];

				if (is_readable($file))
				{
					$contents = file_get_contents($file);
				}
				else
				{
					// TODO Log this
					continue;
				}
				call_user_func($callback, $file, $contents);
			}
		}
	}

}
