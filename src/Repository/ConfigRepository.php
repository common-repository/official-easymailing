<?php

namespace Easymailing\App\Repository;


use Easymailing\App\Core\ParameterBag;
use Easymailing\App\Model\Config;
use Easymailing\App\Utils\Security;

class ConfigRepository
{

	/**
	 * @var ParameterBag
	 */
	private $parameterBag;

	public function __construct(ParameterBag $parameterBag)
	{

		$this->parameterBag = $parameterBag;
	}

	public function saveConfig(Config $config)
	{
		if($config->getApiKey()){
			$config->setApiKey(Security::safeEncrypt($config->getApiKey(), $this->parameterBag->get('encrypt_key')));
		}

		update_option( 'easymailing_configuration', $config );
	}

	/**
	 * @return Config|null
	 */
	public function getConfig()
	{
		$config = get_site_option('easymailing_configuration');

		if($config instanceof Config){
			if($config->getApiKey()){
				$config->setApiKey(Security::safeDecrypt($config->getApiKey(), $this->parameterBag->get('encrypt_key')));
			}

			return $config;
		}

		return null;
	}
}
