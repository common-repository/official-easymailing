<?php


namespace Easymailing\App\Core\Provider;


use Easymailing\App\Core\Application;
use Easymailing\App\Core\Session\FlashBag;

class SessionProvider implements ProviderInterface
{
	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		add_action('init', [$this, 'registerSession']);
	}


	public function registerSession() {
		if(!session_id()) {
			session_start(['read_and_close' => true]);
		}

		$container = $this->application->getContainer();

		$flashBag = new FlashBag();

		$container['flashbag'] = function($c) use ($flashBag) {
			return $flashBag;
		};


	}
}
