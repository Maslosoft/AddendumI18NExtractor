<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package   maslosoft/df
 * @licence   AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link      http://maslosoft.com/df/
 */

namespace Maslosoft\AddendumI18NExtractor\Annotations;

use Maslosoft\Addendum\Collections\MetaAnnotation;

/**
 * Description of field, method or class, used as help tips for users
 * @template   Description('${description}')
 */
class LabelAnnotation extends MetaAnnotation
{

	const Ns = __NAMESPACE__;

	public $value;

	public function init()
	{
		$this->getEntity()->description = $this->value;
	}

	public function __toString()
	{
		return (string)$this->value;
	}

}
