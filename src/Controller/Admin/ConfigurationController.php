<?php

namespace Easymailing\App\Controller\Admin;


use Easymailing\App\Api\Exception\AuthenticationException;
use Easymailing\App\Controller\BaseController;
use Easymailing\App\Model\Config;
use Easymailing\App\Core\Http\Request;

class ConfigurationController extends BaseController
{

	public function errorAction($parameters)
	{
		$this->render('Admin/Configuration/error.php', [
			'message' => $parameters['message']
		]);

	}

	public function indexAction()
	{
		$request = $this->getRequest();
		$repository = $this->getContainer()->get('config_repository');
		$apiKeyWorking = false;
		$client = $this->getContainer()->get('api_client');

		$config = $repository->getConfig();

		$apiKey = null;
		if(!$config){
			$config = Config::create();
		}

		if($request->getMethod() === Request::METHOD_GET){
			if($config->getApiKey()){
				try {
					$client->checkAuth($config->getApiKey());
					$apiKeyWorking = true;
					$apiKey = substr($config->getApiKey(),0, 10)."...";

				}catch(AuthenticationException $e) {

				}
			}

			$this->render('Admin/Configuration/index.php', [
				'apiKeyWorking' => $apiKeyWorking,
				'apiKey' => $apiKey,
				'error' => null
			]);
		}

		// Validation
		$apiKey = sanitize_title($request->request->get('easymailing_api_key'));

		if(empty($apiKey)){
			$config = new Config();
			$repository->saveConfig($config);
			$this->render('Admin/Configuration/index.php', [
				'apiKeyWorking' => $apiKeyWorking,
				'apiKey' => $apiKey,
				'error' => $this->translate('Tienes que introducir la clave api')
			]);
		}


		try {
			$config->setApiKey($apiKey);
			$repository->saveConfig($config);

			$config = $repository->getConfig();
			$mySuscription = $client->getMySuscription();
			$config->setMySuscription($mySuscription);
			$repository->saveConfig($config);

			$apiKey = substr($config->getApiKey(),0, 10)."...";

			$apiKeyWorking = true;
			$this->render('Admin/Configuration/index.php', [
				'apiKeyWorking' => $apiKeyWorking,
				'apiKey' => $apiKey,
				'error' => null
			]);
		}catch(AuthenticationException $e) {
			$this->render('Admin/Configuration/index.php', [
				'apiKeyWorking' => $apiKeyWorking,
				'error' => $e->getMessage(),
				'apiKey' => $apiKey,
			]);
		}



	}



}
