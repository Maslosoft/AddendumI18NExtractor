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
use Maslosoft\AddendumI18NExtractor\Signals\ExtractI18N;
use Maslosoft\Signals\Signal;

/**
 * ReceivingExtractor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ReceivingExtractor implements ExtractorInterface
{

	public function extract(): void
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
