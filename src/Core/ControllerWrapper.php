<?php

namespace Easymailing\App\Core;

class ControllerWrapper
{
	private $controller;
	private $application;

	public function __construct($controller, Application $application)
	{
		$this->controller = $controller;
		$this->application = $application;
	}

	public function __call($method_name, $args) {

		try {
			return call_user_func_array(array($this->controller, $method_name), $args);
		}catch(\Exception $e) {

			if($this->application->isProduction()){
				echo $this->application->getContainer()->get('templating')->render('exception.php', [
					'exception' => $e
				]);
				wp_die();
			}

			throw $e;
		}
	}
}
