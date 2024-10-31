<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Api\Client;
use Easymailing\App\Core\Templating\Templating;
use Easymailing\App\Repository\ConfigRepository;
use Easymailing\App\Utils\Api;

class FormJavascriptProvider
{
	private $application;

	/***
	 * @var Templating
	 */
	private $tempating;

	/***
	 * @var ConfigRepository
	 */
	private $configRepository;

	/***
	 * @var Client
	 */
	private $client;

	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
		$this->tempating = $application->getContainer()->get('templating');
		$this->configRepository = $application->getContainer()->get('config_repository');
		$this->client = $application->getContainer()->get('api_client');
	}

	public function register()
	{
		add_action( 'wp_head', array( $this, 'renderScript' ) );
	}

	public function renderScript()
	{
		$config = $this->configRepository->getConfig();

		if(!$config){
			return;
		}

		if(!$config->getMySuscription()){
			return;
		}

		echo $this->tempating->renderView('Admin/Partials/javascript_form_code.php', [
			'popupForm' => $config->getPopupForm(),
			'mySuscription' => $config->getMySuscription(),
		]);
	}


}
