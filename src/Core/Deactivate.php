<?php

namespace Easymailing\App\Core;

//use Psr\Container\ContainerInterface;

class Deactivate
{
	public static function deactivate()
	{
		// Do nothing
	}

	public static function uninstall()
	{
		delete_option('easymailing_configuration');
	}
}
