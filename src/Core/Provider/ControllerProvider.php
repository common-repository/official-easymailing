<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\ControllerWrapper;

class ControllerProvider implements ProviderInterface
{
	private $application;
	private $adminControllers;

	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		$this->adminControllers = $this->application->getConfigurations()['admin_controllers'];
		if(count($this->adminControllers) > 0){
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}

	}

	public function addAdminMenu()
	{

		foreach($this->adminControllers as $config) {

			$info = explode("::", $config['action']);

			if(!class_exists($info[0])){
				throw new \LogicException(sprintf("%s controller not exists", $info[0]));
			}

			$controller = $this->application->getContainer()->get($info[0]);
			$controllerWrapper = new ControllerWrapper($controller, $this->application);
			$callback = array( $controllerWrapper, $info[1] );


			if($config['parent_slug'] or (!$config['parent_slug'] and !$config['show_in_menu'] )){
				\add_submenu_page( $config['parent_slug'], $config['page_title'], $config['menu_title'], $config['capability'], $config['menu_slug'], $callback, $config['position'] );

				if( !$config['show_in_menu']){
					add_action( 'admin_head', function() use($config) {
						remove_submenu_page( $config['parent_slug'], $config['menu_slug'] );
					});

				}
				continue;
			}

			\add_menu_page( $config['page_title'], $config['menu_title'], $config['capability'], $config['menu_slug'], $callback, $config['icon_url'], $config['position'] );
		}

	}
}
