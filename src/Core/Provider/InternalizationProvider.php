<?php


namespace Easymailing\App\Core\Provider;


class InternalizationProvider implements ProviderInterface
{
	private $application;

	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		add_action('plugins_loaded', [$this, 'loadTranslationFiles']);
	}


	public function loadTranslationFiles() {
		$pluginSlug = $this->application->getConfigurations()['plugin_slug'];
		$pluginFolder = $this->application->getConfigurations()['plugin_folder'];

		load_plugin_textdomain($pluginSlug, false, $pluginFolder.'/languages');
	}
}
