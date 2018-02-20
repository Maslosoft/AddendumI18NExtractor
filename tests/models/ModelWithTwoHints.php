<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.02.18
 * Time: 08:33
 */

namespace Maslosoft\I18NExtractorModels;


use Maslosoft\Addendum\Interfaces\AnnotatedInterface;

/**
 * Class ModelWithMultipleHints
 * @Hint('Hint 1', 'warning')
 * @Hint('Hint 2', 'success')
 * @package Maslosoft\I18NExtractorModels
 */
class ModelWithTwoHints implements AnnotatedInterface
{

}