<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
