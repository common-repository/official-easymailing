<?php


namespace Easymailing\App\Model;


class Audience
{
	public $id;
	public $title;
	public $groups;
	public $listGdpr;

	public $createdAt;
	public $updatedAt;

	public $listFields;

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
