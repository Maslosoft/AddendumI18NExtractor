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
	 * @param string   $file
	 * @param string[] $trimPaths
	 * @return string
	 */
	public static function create(string $file, array $trimPaths = []): string
	{
		// Replace windows slashes
		$file = str_replace('\\', '/', $file);

		// Get path without extension
		$name = sprintf('%s/%s', dirname($file), basename($file, '.php'));

		// Remove search paths in from of file path
		foreach ($trimPaths as $path)
		{
			$pathQuoted = preg_quote($path, '~');
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
