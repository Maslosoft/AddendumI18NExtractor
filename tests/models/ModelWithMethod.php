<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 08:52
 */

namespace Maslosoft\I18NExtractorModels;


use Maslosoft\Addendum\Interfaces\AnnotatedInterface;

class ModelWithMethod implements AnnotatedInterface
{
	/**
	 * @Label('Test')
	 */
	public function action()
	{

	}
}