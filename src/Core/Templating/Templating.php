<?php


namespace Easymailing\App\Core\Templating;


class Templating
{
	private $application;
	public $path;
	public $data = [];


	public function __construct(\Easymailing\App\Core\Application $application)
	{
		$this->application = $application;
		$this->path = $this->application->getConfigurations()['plugin_path'].'templates';
	}

	public function render($template, $parameters = [])
	{
		echo $this->renderView($template, $parameters);
	}

	public function renderView($template, $parameters = [])
	{
		$this->data = array_merge($parameters, $this->data);
		$template = $this->path."/".$template;

		if (!is_file($template)) {
			throw new \RuntimeException('Template not found: ' . $template);
		}

		// define a closure with a scope for the variable extraction
		$result = function($file, array $data = array()) {
			ob_start();
			extract($data, EXTR_SKIP);
			try {
				include $file;
			} catch (\Exception $e) {
				ob_end_clean();
				throw $e;
			}
			return ob_get_clean();
		};

		return $result($template, $this->data);

	}


	public function include($template, $params = [])
	{
		$this->render($template, $params);
	}

	public function asset($path)
	{
		echo $this->application->getConfigurations()['plugin_url']."assets/build/".$path;
	}

	public function adminUrl($slug)
	{
		menu_page_url($slug);
	}

	public function getFlashes($type)
	{
		return $this->application->getContainer()->get('flashbag')->get($type);
	}


	public function getParameter($name)
	{
		return $this->application->getContainer()->get('parameter_bag')->get($name);
	}


}
