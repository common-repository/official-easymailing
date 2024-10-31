<?php

namespace Easymailing\App\Controller;

use Easymailing\App\Core\Container;
use Easymailing\App\Core\Http\Request;


class BaseController
{
	protected $container;

	public function setContainer(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @return mixed
	 */
	public function getContainer(): Container
	{
		return $this->container;
	}

	/**
	 * @return mixed
	 */
	public function getRequest(): Request
	{
		return $this->getContainer()->get('request');
	}


	public function render($template, $parameters = [])
	{
		echo $this->getContainer()->get('templating')->render($template, $parameters);
		wp_die();
	}

	public function translate($msg)
	{
		return __($msg, $this->getContainer()->get('parameter_bag')->get('plugin_slug'));
	}


	public function getParameter($name)
	{
		$parameterBag = $this->getContainer()->get('parameter_bag');

		return $parameterBag->get($name);
	}

	public function forward($class, $method, $parameters = [])
	{
		if(!$this->getContainer()->has($class)) {
			throw new \Exception(sprintf("Controller with class %s not found", $class));
		}

		$this->getContainer()->get($class)->$method($parameters);
		wp_die();
	}

	public function addFlash($type, $message)
	{
		$this->getContainer()->get('flashbag')->add($type, $message);
	}





}
