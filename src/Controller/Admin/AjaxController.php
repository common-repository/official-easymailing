<?php

namespace Easymailing\App\Controller\Admin;



use Easymailing\App\Api\Exception\AuthenticationException;
use Easymailing\App\Controller\BaseController;
use Easymailing\App\Utils\Api;


class AjaxController extends BaseController
{

	public function isApiKeyValidAction()
	{
		$client = $this->getContainer()->get('api_client');
		$repository = $this->getContainer()->get('config_repository');

		$config = $repository->getConfig();



		if($config and $config->getApiKey()){
			try {
				$client->checkAuth($config->getApiKey());
				wp_send_json([
					'valid' => true
				]);
				wp_die();

			}catch(AuthenticationException $e) {
				wp_send_json([
					'valid' => false,
					'message' => __('La clave API no es correcta', 'easymailing'),
				]);
				wp_die();
			}
		}

		wp_send_json([
			'valid' => false,
			'message' => __('Tienes que añadir tu clave API a la configuración del plugin', 'easymailing'),
		]);
		wp_die();
	}


	public function getEmbeddedFormsAction()
	{
		$client = $this->getContainer()->get('api_client');
		$audience = $this->getRequest()->query->get('audience');

		$forms = $client->getForms($audience, [
			'type' => 'embedded',
			'active' => true,
		]);

		wp_send_json($forms);
		wp_die();
	}


	public function getPopupFormsAction()
	{
		$client = $this->getContainer()->get('api_client');
		$audience = $this->getRequest()->query->get('audience');
		$forms = $client->getForms($audience, [
			'type' => 'popup',
			'active' => true,
		]);

		wp_send_json($forms);
		wp_die();
	}

	public function getAudiencesAction()
	{
		$client = $this->getContainer()->get('api_client');
		$audiences = $client->getAudiences();
		wp_send_json($audiences);
		wp_die();
	}



}
