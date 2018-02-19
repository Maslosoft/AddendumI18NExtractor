<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\AddendumI18NExtractor\Helpers;
use function array_values;
use function preg_replace;
use function ucwords;

/**
 * Context
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Context
{

	/**
	 * Create context based on file name
	 * @param string $file
	 * @param string[] $trimPaths
	 * @return string
	 */
	public static function create($file, $trimPaths = [])
	{
		// Replace windows slashes
		$file = str_replace('\\', '/', $file);

		// Get path without extension
		$name = sprintf('%s/%s', dirname($file), basename($file, '.php'));

		// Remove search paths in from of file path
		foreach ($trimPaths as $path)
		{
			$pathQuoted = preg_quote($path);
			$pattern = "~^$pathQuoted/~";
			if (preg_match($pattern, $name))
			{
				$name = preg_replace($pattern, '', $name);
			}
		}

		// Trim out any remaining slashed
		$name = trim($name, '\\/');

		// Convert to dots
		$name = str_replace('/', '.', $name);
		// Remove some parts

		$patterns = [
			'~^src\\.~' => '',
			'~\\.views\\.~' => '.'
		];
		$name = preg_replace(array_keys($patterns), array_values($patterns), $name);
		return ucwords($name, '.');
	}

}
