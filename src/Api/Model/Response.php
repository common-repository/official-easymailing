<?php

namespace Easymailing\App\Api\Model;

class Response
{
	private $statusCode;
	private $body;

	public function __construct($statusCode, $body)
	{
		$this->statusCode = $statusCode;
		$this->body = $body;
	}


	public static function init($statusCode, $body)
	{
		return new self($statusCode, $body);
	}


	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param mixed $statusCode
	 */
	public function setStatusCode($statusCode): self
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body): self
	{
		$this->body = $body;

		return $this;
	}

	public function getError()
	{
		if($this->statusCode !== 200){
			if(array_key_exists('message', $this->body) !== false){
				return $this->body['message'];
			}
		}

		return null;
	}






}
