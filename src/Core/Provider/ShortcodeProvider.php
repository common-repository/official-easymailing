<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\ControllerWrapper;

class ShortcodeProvider implements ProviderInterface
{
	private $application;
	private $shortcodes;


	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;


	}

	public function register()
	{
		$this->shortcodes = $this->application->getConfigurations()['shortcodes'];
		add_action('init', [$this, 'addShortcodes']);

	}

	public function addShortcodes()
	{

		foreach($this->shortcodes as $shortcode) {

			$info = explode("::", $shortcode['action']);

			if(!class_exists($info[0])){
				throw new \LogicException(sprintf("%s controller not exists", $info[0]));
			}

			$controller = $this->application->getContainer()->get($info[0]);
			$controllerWrapper = new ControllerWrapper($controller, $this->application);
			$callback = array( $controllerWrapper, $info[1] );


			add_shortcode( $shortcode['name'], $callback );

		}

	}
}
