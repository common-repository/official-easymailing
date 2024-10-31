<?php


namespace Easymailing\App\Utils;


class Api
{


	public static function extractUuid($identifier)
	{
		if(!$identifier){
			return null;
		}
		$data = explode("/", $identifier);

		return end($data);

	}
}
