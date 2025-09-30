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

use Maslosoft\AddendumI18NExtractor\Interfaces\FillerInterface;

/**
 * DirectoryContextFiller
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class DirectoryContextFiller implements FillerInterface
{

	public function fill($src = 'src'): void
	{
		$extractor = new ContextFiller();
		$extractor->fill([$src]);
	}

}
