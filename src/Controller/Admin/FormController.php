<?php

namespace Easymailing\App\Controller\Admin;


use Easymailing\App\Api\Client;
use Easymailing\App\Api\Exception\AuthenticationException;
use Easymailing\App\Controller\BaseController;
use Easymailing\App\Core\Http\Request;
use Easymailing\App\Model\Config;
use Easymailing\App\Utils\Api;


class FormController extends BaseController
{

	public function indexAction()
	{
		$this->checkConfig();

		$this->render('Admin/Form/index.php', []);

	}



	public function embeddedAction()
	{
		$this->checkConfig();
		$repository = $this->getContainer()->get('config_repository');
		/** @var $client Client */
		$client = $this->getContainer()->get('api_client');
		/** @var $config Config */
		$config = $repository->getConfig();

		$audiences = $client->getAudiences();

		$this->render('Admin/Form/embedded.php', [
			'config' => $config,
			'audiences' => $audiences,
		]);


	}

	public function popupAction()
	{
		$this->checkConfig();
		$repository = $this->getContainer()->get('config_repository');
		/** @var $client Client */
		$client = $this->getContainer()->get('api_client');
		/** @var $config Config */
		$config = $repository->getConfig();

		if($this->getRequest()->getMethod() === Request::METHOD_GET){

			if($config->getPopupForm()){
				 $this->forward('Easymailing\App\Controller\Admin\FormController','showPopupAction');
			}

			$this->forward('Easymailing\App\Controller\Admin\FormController','updatePopupAction');
		}

		if($this->getRequest()->getMethod() === Request::METHOD_POST and $this->getRequest()->request->get('_method') === "DELETE"){
			$config->setAudience(null);
			$config->setPopupForm(null);
			$repository->saveConfig($config);

			$this->addFlash('success', __('El formulario se ha eliminado correctamente', 'easymailing'));

			$this->forward('Easymailing\App\Controller\Admin\FormController','updatePopupAction');
		}

		$audienceId = $this->getRequest()->request->get('audience_id');
		$popupFormId = $this->getRequest()->request->get('suscription_form_id');


		if($audienceId && $popupFormId){

			$audience = $client->getAudienceById($audienceId);
			$popupForm = $client->getFormById($popupFormId);

			$config->setAudience($audience);
			$config->setPopupForm($popupForm);

			$repository->saveConfig($config);

			$this->addFlash('success', __('El formulario se ha configurado correctamente', 'easymailing'));
			$this->forward('Easymailing\App\Controller\Admin\FormController','showPopupAction');
		}

	}


	public function updatePopupAction()
	{
		$client = $this->getContainer()->get('api_client');
		$repository = $this->getContainer()->get('config_repository');
		/** @var $config Config */
		$config = $repository->getConfig();


		$audiences = $client->getAudiences();

		$this->render('Admin/Form/popup.php', [
			'config' => $config,
			'audiences' => $audiences,
		]);
	}


	public function showPopupAction()
	{
		$repository = $this->getContainer()->get('config_repository');
		/** @var $config Config */
		$config = $repository->getConfig();

		$this->render('Admin/Form/popup_show.php', [
			'config' => $config,
		]);
	}

	private function checkConfig()
	{
		$repository = $this->getContainer()->get('config_repository');
		$config = $repository->getConfig();
		$client = $this->getContainer()->get('api_client');

		if(!$config){
			$this->forward('Easymailing\App\Controller\Admin\ConfigurationController','indexAction');
		}

		if(!$config->getApiKey()){
			$this->forward('Easymailing\App\Controller\Admin\ConfigurationController','indexAction');
		}

		try {
			$client->checkAuth($config->getApiKey());
		}catch(AuthenticationException $e) {
			$this->forward('Easymailing\App\Controller\Admin\ConfigurationController','indexAction');
		}
//		catch(\Throwable $e) {
//			$this->forward('Easymailing\App\Controller\Admin\ConfigurationController','errorAction', ['message' => 'Se produjo un error al intentar conectar con el API de Easymailing. Por favor, inténtelo de nuevo más tarde.']);
//		}
	}


}
