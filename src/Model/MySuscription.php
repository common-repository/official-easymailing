<?php


namespace Easymailing\App\Model;


class MySuscription
{

	public $credits;
	public $creditsUsed;
	public $suscribersUsed;
	public $maxSuscribers;
	public $expirationDate;
	public $domain;
	public $tier;
	public $locale;


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
