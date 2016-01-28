<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
