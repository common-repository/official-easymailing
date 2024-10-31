<?php

namespace Easymailing\App\Controller;

use Easymailing\App\Core\Container;

class ShortcodeController
{
	protected $container;

	public function setContainer(Container $container)
	{
		$this->container = $container;
	}

	public function embeddedForAction($atts, $content, $tag)
	{
		if(!array_key_exists('hash', $atts)){
			return __('Error - Te falta el atributo "hash" en el shortcode', 'easymailing');
		}
		return sprintf("<div data-easymform=\"%s\"></div>", $atts['hash']);

	}

}
