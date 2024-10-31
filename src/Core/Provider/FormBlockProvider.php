<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\Application;

class FormBlockProvider
{

	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		add_action('init', [$this, 'registerScripts']);
	}

	public function registerScripts()
	{
		if ( function_exists( 'register_block_type' ) ) {
			$pluginUrl = $this->application->getConfigurations()['plugin_url'];
			wp_register_script('easymailing-form-block-js', $pluginUrl . '/assets/build/block/form_block_script.js', [
				'wp-blocks',
				'wp-components',
				'wp-element',
				'wp-editor',
				'wp-i18n',
				'wp-block-editor',

			],
				$this->application->getConfigurations()['plugin_version']
			);

			wp_register_style('easymailing-form-block-css', $pluginUrl . '/assets/build/block/form_block_style.css', []);



			register_block_type( 'easymailing/form-block', [
				'editor_script' => 'easymailing-form-block-js',
				'style' => 'easymailing-form-block-css',
			]);
		}

	}
}
