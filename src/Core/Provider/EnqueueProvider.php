<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\Application;

class EnqueueProvider implements ProviderInterface
{
	private $application;
	private $adminStyles;
	private $adminScrips;

	public function __construct(Application $application)
	{
		$this->application = $application;

		$this->adminStyles = [];
		$this->adminScrips = [];
	}

	public function register()
	{
		$admin = $this->application->getConfigurations()['admin_enqueue'];

		if(array_key_exists('css', $admin) !== false){
			$this->adminStyles = $admin['css'];
		}

		if(array_key_exists('scripts', $admin) !== false){
			$this->adminScrips = $admin['scripts'];
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueue' ) );
	}


	public function adminEnqueue() {
		$pluginUrl = $this->application->getConfigurations()['plugin_url'];

		foreach($this->adminStyles as $adminStyle) {
			wp_enqueue_style( $adminStyle['id'], $pluginUrl . 'assets/build/'.$adminStyle['file'] );
		}

		foreach($this->adminScrips as $adminScrip) {
			wp_enqueue_script( $adminScrip['id'], $pluginUrl . 'assets/build/'.$adminScrip['file'] );
			wp_localize_script($adminScrip['id'],'easymailingVars',[
				'ajaxurl' => admin_url('admin-ajax.php'),
				'plugin_configuration_url' => menu_page_url('easymailing_configuration', false),
			]);
		}


	}
}
