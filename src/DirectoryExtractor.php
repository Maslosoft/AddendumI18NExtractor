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

use Maslosoft\AddendumI18NExtractor\Interfaces\ExtractorInterface;

/**
 * DirectoryExtractor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class DirectoryExtractor implements ExtractorInterface
{

	public function extract($src = 'src', $dest = 'generated')
	{
		$extractor = new I18NExtractor();
		$extractor->generate([$src], $dest);
	}

}
