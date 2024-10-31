<?php


namespace Easymailing\App\Core;


use Easymailing\App\Core\Exception\ParameterException;

class ParameterBag
{

	protected $parameters = [];

	/**
	 * @param array $parameters An array of parameters
	 */
	public function __construct(array $parameters = [])
	{
		$this->add($parameters);
	}

	/**
	 * Clears all parameters.
	 */
	public function clear()
	{
		$this->parameters = [];
	}

	/**
	 * Adds parameters to the service container parameters.
	 *
	 * @param array $parameters An array of parameters
	 */
	public function add(array $parameters)
	{
		foreach ($parameters as $key => $value) {
			$this->set($key, $value);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function all()
	{
		return $this->parameters;
	}


	public function get($name)
	{
		if (\array_key_exists($name, $this->parameters) === false){
			ParameterException::notFound($name);
		}

		return $this->parameters[$name];
	}


	/**
	 * Sets a service container parameter.
	 *
	 * @param string $name  The parameter name
	 * @param mixed  $value The parameter value
	 */
	public function set($name, $value)
	{
		$this->parameters[(string) $name] = $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($name)
	{
		return \array_key_exists((string) $name, $this->parameters);
	}

	/**
	 * Removes a parameter.
	 *
	 * @param string $name The parameter name
	 */
	public function remove($name)
	{
		unset($this->parameters[(string) $name]);
	}
}
