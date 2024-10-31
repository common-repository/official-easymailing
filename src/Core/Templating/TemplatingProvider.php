<?php

namespace Easymailing\App\Core\Templating;

use Easymailing\App\Core\ClassHelper;


class TemplatingProvider
{
	private $application;
	private $container;

	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
		$this->container = $application->getContainer();
	}

	public function register()
	{

		$templateEngine = new Templating($this->application);

		$this->container['templating'] = function($c) use ($templateEngine) {
			return $templateEngine;
		};
	}
}
