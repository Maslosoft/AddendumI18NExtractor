<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 09:00
 */

namespace Maslosoft\AddendumI18NExtractor\Helpers;


use Maslosoft\AddendumI18NExtractor\I18NExtractor;
use Maslosoft\MiniView\MiniView;

class MessageRenderer
{
	/**
	 * Extractor instance
	 * @var I18NExtractor
	 */
	private $extractor;


	public function __construct(I18NExtractor $extractor)
	{
		$this->extractor = $extractor;
	}

	public function render($file, $name, $message)
	{
		$context = ClassContext::create($file);
		$alias = basename($file);
		$parts = explode('.', $alias);
		array_pop($parts);
		$class = array_pop($parts);

		$delimiter = "'";
		if (strstr($message, "'") !== false)
		{
			$delimiter = '"';
		}

		return <<<TPL
// $alias
$$name = tx($delimiter$message$delimiter, '$context');
TPL;
	}
}