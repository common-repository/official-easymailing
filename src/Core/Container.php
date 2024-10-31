<?php


namespace Easymailing\App\Core;

use Easymailing\App\Core\Container\Container as BaseContainer;

class Container extends BaseContainer
{
	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function get($id )
	{
		return $this->offsetGet($id);
	}

	/**
	 * @param $id
	 * @param $value
	 */
	public function set($id, $value)
	{
		$this->offsetSet($id, $value);
	}

	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id)
	{
		return isset($this[$id]);
	}


}
