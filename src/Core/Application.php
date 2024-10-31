<?php

namespace Easymailing\App\Core;


use Easymailing\App\Core\Http\Request;
use Easymailing\App\Core\Templating\TemplatingProvider;



class Application
{
	protected static $instance;

	const PLUGIN_SLUG = 'easymailing';

	/**
	 * @var Container
	 */
	protected $container;
	protected $configurations;
	protected $env;

	public function __construct()
	{
		static::$instance = $this;
	}

	public function boot($root, $env): void
	{
		if($env !== 'production' and $env !== 'development'){
			throw new \Exception('Environment does not exists, please add "development" or "production" in easymailing-official.php');
		}

		$this->container = new Container();

		$this->env = $env;
		$this->configurations['plugin_version'] = EASYMAILING_OFFICIAL_VERSION;
		$this->configurations['plugin_path'] = $root;
		$this->configurations['plugin_slug'] = self::PLUGIN_SLUG;
		$this->configurations['plugin_url'] = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->configurations['plugin_folder'] =  plugin_basename(dirname( __FILE__, 3 )) ;
		$this->configurations['request'] = Request::createFromGlobals();
		$this->configurations['parameters'] = require ($root."config/app.parameters_".$env.".php") ?: [];
		$this->configurations['services'] = require ($root."config/app.services.php") ?: [];
		$this->configurations['admin_controllers'] = require ($root."config/app.admin.controllers.php") ?: [];
		$this->configurations['admin_enqueue'] = require ($root."config/app.admin.enqueue.php") ?: [];
		$this->configurations['admin_ajax_actions'] = require ($root."config/app.admin.ajax.php") ?: [];
		$this->configurations['shortcodes'] = require ($root."config/app.shortcodes.php") ?: [];


		$this->registerServices();
		$this->registerRequest();
		$this->registerParameters();
		$this->registerTemplating();
		$this->registerControllers();
		$this->registerProviders();
	}


	private function registerServices(): void
	{
		foreach($this->configurations['services'] as $name => $config){

			$this->container[$name] = function($c) use ($config) {
				if(array_key_exists('arguments', $config) === false){
					return new $config['class']();
				}

				$arguments = [];
				foreach($config['arguments'] as $argument) {
					$arguments[] = $c->get($argument);
				}

				$reflection = new \ReflectionClass($config['class']);
				return $reflection->newInstanceArgs($arguments);
			};
		}
	}

	private function registerRequest(): void
	{
		$request = $this->configurations['request'];
		$this->container['request'] = function($c) use ($request) {
			return $request;
		};
	}

	private function registerParameters(): void
	{
		$parameterBag = new ParameterBag($this->configurations['parameters']);
		$parameterBag->set('plugin_path', $this->configurations['plugin_path']);
		$parameterBag->set('plugin_slug', $this->configurations['plugin_slug']);

		$this->container['parameter_bag'] = function($c) use ($parameterBag) {
			return $parameterBag;
		};
	}

	private function registerTemplating(): void
	{
		(new TemplatingProvider($this))->register();
	}

	private function registerControllers(): void
	{
		$fqcns = ClassHelper::getFqcns($this->configurations['plugin_path']."src/Controller", true);

		foreach($fqcns as $fqcn) {
			$controller = new $fqcn();
			$this->container[$fqcn] = function($c) use ($controller) {
				$controller->setContainer($c);
				return $controller;
			};
		}
	}

	private function registerProviders(): void
	{
		$fqcns = ClassHelper::getFqcns($this->configurations['plugin_path']."src/Core/Provider", false);

		foreach($fqcns as $fqcn) {
			(new $fqcn($this))->register();
		}
	}



	/**
	 * @return string
	 */
	public function getEnv()
	{
		return $this->env;
	}


	/**
	 * @return bool
	 */
	public function isProduction()
	{
		return $this->env === 'production';
	}



	/**
	 * @return mixed
	 */
	public function getConfigurations()
	{
		return $this->configurations;
	}

	/**
	 * @return Container
	 */
	public function getContainer(): Container
	{
		return $this->container;
	}



	public static function getInstance(): self
	{
		if (is_null(static::$instance)){
			static::$instance = new static;
		}

		return static::$instance;
	}
}
