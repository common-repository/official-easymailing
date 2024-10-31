<?php


namespace Easymailing\App\Api;

class Hydrator
{
	public function hydrate($responseBody)
	{
		if ($responseBody['@type'] === "hydra:Collection") {
			$contextData = explode("/", $responseBody['@context']);
			return $this->hydrateCollection($responseBody, end($contextData));
		}

		return $this->hydrateObject($responseBody, $responseBody['@type']);
	}

	private function hydrateObject($responseBody, $className)
	{
		$class = "Easymailing\\App\\Model\\" . $className;
		if (!class_exists($class)) {
			return null; // O manejar de otra manera si la clase no existe
		}
		$object = new $class();

		$object->id = $responseBody['@id'];
		foreach (array_keys($responseBody) as $key) {
			if (strpos($key, '@') === 0) continue; // Ignorar metadata como @context, @type, etc.

			$property = $this->camelize($key);
			if (property_exists($class, $property)) {
				$value = $responseBody[$key];
				if (is_array($value) && isset($value['@type'])) {
					// Tratar como objeto
					$object->$property = $this->hydrateObject($value, $value['@type']);
				} elseif (is_array($value) && is_numeric(array_key_first($value))) {
					// Tratar como colección
					$object->$property = [];
					foreach ($value as $item) {
						if (isset($item['@type'])) {
							$object->$property[] = $this->hydrateObject($item, $item['@type']);
						}
					}
				} else {
					$object->$property = $value;
				}
			}
		}
		return $object;
	}

	private function hydrateCollection($responseBody, $className)
	{
		$array = [];
		foreach ($responseBody['hydra:member'] as $data) {
			$hydratedObject = $this->hydrateObject($data, $className);
			if ($hydratedObject !== null) {
				$array[] = $hydratedObject;
			}
		}
		return $array;
	}

	function camelize($input, $separator = '_')
	{
		return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
	}
}
