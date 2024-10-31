<?php


namespace Easymailing\App\Core\Http;


final class InputBag extends ParameterBag
{
	/**
	 * Returns a string input value by name.
	 *
	 * @param string|null $default The default value if the input key does not exist
	 *
	 * @return string|null
	 */
	public function get(string $key, $default = null)
	{
		$value = parent::get($key, $this);
		return $this === $value ? $default : $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function all(string $key = null): array
	{
		return parent::all($key);
	}

	/**
	 * Replaces the current input values by a new set.
	 */
	public function replace(array $inputs = [])
	{
		$this->parameters = [];
		$this->add($inputs);
	}

	/**
	 * Adds input values.
	 */
	public function add(array $inputs = [])
	{
		foreach ($inputs as $input => $value) {
			$this->set($input, $value);
		}
	}

	/**
	 * Sets an input by name.
	 *
	 * @param string|array|null $value
	 */
	public function set(string $key, $value)
	{

		$this->parameters[$key] = $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function filter(string $key, $default = null, int $filter = \FILTER_DEFAULT, $options = [])
	{
		$value = $this->has($key) ? $this->all()[$key] : $default;

		// Always turn $options into an array - this allows filter_var option shortcuts.
		if (!\is_array($options) && $options) {
			$options = ['flags' => $options];
		}

		return filter_var($value, $filter, $options);
	}
}
