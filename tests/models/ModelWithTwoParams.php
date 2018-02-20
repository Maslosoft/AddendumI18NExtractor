<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 07:40
 */

namespace Maslosoft\I18NExtractorModels;


use Maslosoft\Addendum\Interfaces\AnnotatedInterface;

class ModelWithTwoParams implements AnnotatedInterface
{

	/**
	 * @Hint('Title', 'success')
	 * @var string
	 */
	public $title = '';
}