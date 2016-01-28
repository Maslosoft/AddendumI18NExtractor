<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

	public function fill($src = 'src')
	{
		$extractor = new ContextFiller();
		$extractor->fill([$src]);
	}

}
