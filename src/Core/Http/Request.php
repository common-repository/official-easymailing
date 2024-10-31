<?php
namespace Easymailing\App\Core\Http;

class Request
{

	public const METHOD_HEAD = 'HEAD';
	public const METHOD_GET = 'GET';
	public const METHOD_POST = 'POST';
	public const METHOD_PUT = 'PUT';
	public const METHOD_PATCH = 'PATCH';
	public const METHOD_DELETE = 'DELETE';
	public const METHOD_PURGE = 'PURGE';
	public const METHOD_OPTIONS = 'OPTIONS';
	public const METHOD_TRACE = 'TRACE';
	public const METHOD_CONNECT = 'CONNECT';


	public $method;
	public $request;
	public $query;
	public $attributes;
	public $cookies;
	public $server;
	public $headers;
	public $content;



	public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
	{
		$this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
	}


	public function initialize(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
	{
		$this->request = new ParameterBag($request);
		$this->query = new InputBag($query);
		$this->attributes = new ParameterBag($attributes);
		$this->cookies = new InputBag($cookies);
		$this->server = new ServerBag($server);
		$this->headers = new HeaderBag($this->server->getHeaders());

		$this->content = $content;

	}

	private static function createRequestFromFactory(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null): self
	{
		return new static($query, $request, $attributes, $cookies, $files, $server, $content);
	}

	public static function createFromGlobals()
	{
		$request = self::createRequestFromFactory($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

		if (str_starts_with($request->headers->get('CONTENT_TYPE', ''), 'application/x-www-form-urlencoded')
		    && \in_array(strtoupper($request->server->get('REQUEST_METHOD', 'GET')), ['PUT', 'DELETE', 'PATCH'])
		) {
			parse_str($request->getContent(), $data);
			$request->request = new InputBag($data);
		}

		return $request;
	}

	public function getContent(bool $asResource = false)
	{
		$currentContentIsResource = \is_resource($this->content);

		if (true === $asResource) {
			if ($currentContentIsResource) {
				rewind($this->content);

				return $this->content;
			}

			// Content passed in parameter (test)
			if (\is_string($this->content)) {
				$resource = fopen('php://temp', 'r+');
				fwrite($resource, $this->content);
				rewind($resource);

				return $resource;
			}

			$this->content = false;

			return fopen('php://input', 'r');
		}

		if ($currentContentIsResource) {
			rewind($this->content);

			return stream_get_contents($this->content);
		}

		if (null === $this->content || false === $this->content) {
			$this->content = file_get_contents('php://input');
		}

		return $this->content;
	}

	public function getMethod()
	{
		if (null !== $this->method) {
			return $this->method;
		}

		return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));

	}



}
