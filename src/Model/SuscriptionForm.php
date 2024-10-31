<?php


namespace Easymailing\App\Model;


class SuscriptionForm
{
	public $id;
	public $title;
	public $type;
	public $active;
	public $paused;
	public $audience;
	public $hash;
	public $url;
	public $domain;
	public $doubleOptIn;
	public $enableWelcomeEmail;

	public function toArray()
	{
		$array = get_object_vars($this);
		unset($array['_parent'], $array['_index']);
		array_walk_recursive($array, function (&$property) {
			if (is_object($property) && method_exists($property, 'toArray')) {
				$property = $property->toArray();
			}
		});
		return $array;
	}

}
