<?php

namespace Easymailing\App\Core\Session;

class FlashBag
{
	private $storageKey = '_easymailing_flashes';

	public function __construct()
	{
		if (!is_array($_SESSION)) {
			if(!session_id()) {
				session_start(['read_and_close' => true]);
			}
		}

		if(!array_key_exists($this->storageKey, $_SESSION)){
			$_SESSION[$this->storageKey] = [];
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function add(string $type, $message)
	{
		$_SESSION[$this->storageKey][sanitize_key($type)][] = sanitize_text_field($message);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get(string $type, array $default = [])
	{
		if (!$this->has($type)) {
			return $default;
		}

		$return = $_SESSION[$this->storageKey][sanitize_key($type)];

		unset($_SESSION[$this->storageKey][sanitize_key($type)]);

		return $return;
	}

	public function has(string $type)
	{
		return \array_key_exists(sanitize_key($type), $_SESSION[$this->storageKey]) && $_SESSION[$this->storageKey][sanitize_key($type)];
	}
}
