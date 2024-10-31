<?php

namespace Easymailing\App\Core\Provider;

interface ProviderInterface {

	public function __construct(\Easymailing\App\Core\Application $application);
	public function register();


}
