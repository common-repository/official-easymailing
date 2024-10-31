<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\ControllerWrapper;

class AjaxProvider implements ProviderInterface
{
	private $application;
	private $ajaxActions;


	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		$this->ajaxActions = $this->application->getConfigurations()['admin_ajax_actions'];


		$this->addActions();

	}

	public function addActions()
	{

		foreach($this->ajaxActions as $ajaxAction) {

			$info = explode("::", $ajaxAction['action']);

			if(!class_exists($info[0])){
				throw new \LogicException(sprintf("%s controller not exists", $info[0]));
			}

			$controller = $this->application->getContainer()->get($info[0]);
			$controllerWrapper = new ControllerWrapper($controller, $this->application);
			$callback = array( $controllerWrapper, $info[1] );


			add_action('wp_ajax_'.$ajaxAction['name'], $callback);


		}

	}
}
