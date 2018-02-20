<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/df
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/df/
 */

namespace Maslosoft\AddendumI18NExtractor\Annotations;

use Maslosoft\Addendum\Collections\MetaAnnotation;
use Maslosoft\Addendum\Helpers\ParamsExpander;
use Maslosoft\Components\Meta\HintMeta;
use Maslosoft\Components\Meta\DfPropertyAnnotation;
use UnexpectedValueException;

/**
 * Hint for field, method or class, used as help tips for users. This could also
 * contain warning or other type of additional message by placing proper message
 * type. This is defined by MessageType enumeration.
 *
 * Examples:
 * ```
 * @Hint('My custom message')
 * @Hint('My custom warning', MessageType::Warning)
 * ```
 *
 * Can also be used with long notation:
 *
 * ```
 * @Hint(message = 'My custom message', type = MessageType::Warning)
 * @Hint('My custom warning', MessageType::Warning)
 * ```
 *
 * When using many Hint annotations, hints will be added. Then this could be
 * displayed one after another.
 *
 * @template Hint('${hint}')
 */
class HintAnnotation extends MetaAnnotation
{

	const Ns = __NAMESPACE__;

	public $value;
	public $message;
	public $type;

	public function init()
	{
		$data = ParamsExpander::expand($this, ['message', 'type']);
		if (empty($data) || empty($data['message']))
		{
			throw new UnexpectedValueException(sprintf('Message is required for for @Hint, defined at `%s` model, on `%s`', $this->getMeta()->type()->name, $this->getEntity()->name));
		}
		$hints = $this->getEntity()->hints;
		if(empty($hints))
		{
			$hints = [];
		}
		foreach ($data as $key => $value)
		{
			$hints[] = $value;
		}
		$this->getEntity()->hints = $hints;
	}

	public function __toString()
	{
		return (string) $this->value[0];
	}

}
