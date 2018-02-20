<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 07:40
 */

namespace Maslosoft\I18NExtractorModels;


use Maslosoft\Addendum\Interfaces\AnnotatedInterface;
use Maslosoft\I18NExtractorModels\Traits\Keywords;

class ModelWithTrait implements AnnotatedInterface
{
	use Keywords;

	/**
	 * @Label('Title')
	 * @var string
	 */
	public $title = '';
}