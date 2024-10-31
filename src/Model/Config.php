<?php

namespace Easymailing\App\Model;

class Config
{

	private $apiKey;
	private $mySuscription;
	private $audience;
	private $popupForm;

	public static function create()
	{
		return new self();
	}



	/**
	 * @return mixed
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @param mixed $apiKey
	 */
	public function setApiKey($apiKey): self
	{
		$this->apiKey = $apiKey;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMySuscription()
	{
		return $this->mySuscription;
	}

	/**
	 * @param mixed $mySuscription
	 */
	public function setMySuscription($mySuscription): self
	{
		$this->mySuscription = $mySuscription;

		return $this;
	}




	/**
	 * @return mixed
	 */
	public function getAudience()
	{
		return $this->audience;
	}

	/**
	 * @param mixed $audience
	 */
	public function setAudience($audience): self
	{
		$this->audience = $audience;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPopupForm()
	{
		return $this->popupForm;
	}

	/**
	 * @param mixed $popupForm
	 */
	public function setPopupForm($popupForm): self
	{
		$this->popupForm = $popupForm;

		return $this;
	}




}
