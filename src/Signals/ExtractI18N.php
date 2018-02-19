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

namespace Maslosoft\AddendumI18NExtractor\Signals;

use Maslosoft\Signals\Interfaces\SignalInterface;

/**
 * Signal used to extract i18n information from receiving components
 */
class ExtractI18N implements SignalInterface
{

	/**
	 * Annotations to search for.
	 * @var string[]
	 */
	public $annotations = [
		'Label',
		'Description'
	];

	/**
	 * Path for searching for I18N annotations
	 * @var string
	 */
	public $srcPath = '';

	/**
	 * Generated php file path
	 * @var string
	 */
	public $destPath = '';

}
