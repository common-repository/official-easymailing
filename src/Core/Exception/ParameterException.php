<?php

namespace Easymailing\App\Core\Exception;


class ParameterException extends \InvalidArgumentException
{

	private const MESSAGE = 'Parameter not found: %s';

	public static function notFound($name): self
	{
		throw new self(\sprintf(self::MESSAGE, $name));
	}
}
