<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\AddendumI18NExtractor;

use Maslosoft\AddendumI18NExtractor\Signals\ExtractI18N;
use Maslosoft\Signals\Signal;

/**
 * ReceivingExtractor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ReceivingExtractor
{

	public function extract()
	{
		$signals = (new Signal)->emit(new ExtractI18N);

		$extractor = new I18NExtractor();

		foreach ($signals as $signal)
		{
			/* @var $signal ExtractI18N */
			$extractor->generate($signal->srcPath, $signal->destPath);
		}
	}

}
