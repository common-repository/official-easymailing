<?php

namespace Easymailing\App\Api;



use Easymailing\App\Api\Exception\AuthenticationException;
use Easymailing\App\Api\Exception\NotFoundException;
use Easymailing\App\Api\Exception\RequestException;
use Easymailing\App\Api\Exception\ServerException;
use Easymailing\App\Api\Model\Response;
use Easymailing\App\Core\ParameterBag;
use Easymailing\App\Repository\ConfigRepository;

class Client
{

	private $parameterBag;
	private $configRepository;
	private $hydrator;

	public function __construct(ParameterBag $parameterBag, ConfigRepository $configRepository, Hydrator $hydrator)
	{
		$this->parameterBag = $parameterBag;
		$this->configRepository = $configRepository;
		$this->hydrator = $hydrator;
	}


	public function checkAuth($apiKey)
	{
		$wpResponse = wp_remote_get( $this->parameterBag->get('api_base_uri'), [
			'headers' => [
				'X-Auth-Token' => $apiKey
			]
		]);

		return $this->buildResponse($wpResponse);
	}

	public function getMySuscription()
	{
		return $this->hydrator->hydrate($this->doRequest('GET','/my_suscription')->getBody());
	}

	public function getAudiences()
	{
		return $this->hydrator->hydrate($this->doRequest('GET','/audiences')->getBody());
	}

	public function getAudienceById($iri)
	{
		$data = $this->doRequest('GET',$iri)->getBody();
		return $this->hydrator->hydrate($data);

	}

	public function getForms($audience, $query)
	{
		return $this->hydrator->hydrate($this->doRequest('GET',$audience.'/suscription_forms', $query)->getBody());
	}


	public function getFormById($iri)
	{
		return $this->hydrator->hydrate($this->doRequest('GET',$iri)->getBody());
	}


	public function createMember($audienceIri, $data)
	{
		$data = $this->doRequest('POST',$audienceIri.'/members', null, $data)->getBody();
		return $this->hydrator->hydrate($data);

	}

	protected function doRequest($method, $endPoint, $query = null, $body = null)
	{
		$this->configRepository->getConfig()->getApiKey();
		$url = $this->parameterBag->get('api_base_uri').$endPoint;

		if($query){
			$url .= "?".http_build_query($query);
		}

		if ($body !== null) {
			$body = json_encode($body);
		}

		$wpResponse = wp_remote_get( $url, [
			'timeout'=> 10,
			'method' => $method,
			'headers' => [
				'Content-Type' => 'application/ld+json',
				'X-Auth-Token' => $this->configRepository->getConfig()->getApiKey(),
			],
			'body' => $body,
			'query' => $query
		]);

		return $this->buildResponse($wpResponse);
	}


	private function buildResponse($wpResponse)
	{
		$body = null;
		$statusCode = (int) wp_remote_retrieve_response_code($wpResponse);
		$jsonResponse = wp_remote_retrieve_body($wpResponse);


		if($jsonResponse){
			$body = json_decode($jsonResponse, true);
		}

		if($statusCode === 200 or $statusCode === 201 or $statusCode === 204){
			return Response::init($statusCode, $body);
		}

		throw $this->getException($body, $statusCode);

	}

	private function getException($body, $status)
	{
		$errorTitle = null;

		if(is_array($body)){
			if(array_key_exists('hydra:title', $body)){
				$errorTitle = $body['hydra:title'];
				if(array_key_exists('hydra:description', $body)){
					$errorTitle .=  ": ".$body['hydra:description'];
				}
			}

			if(array_key_exists('message', $body)){
				$errorTitle = $body['message'];
			}
		}

		if(!$errorTitle){
			$errorTitle = 'Unexpected error';
		}

		if ($status === 401){
			$e = new AuthenticationException($errorTitle, $status);
		} elseif ($status === 404){
			$e = new NotFoundException($errorTitle, $status);
		} elseif ($status >= 400 && $status < 500) {
			$e = new RequestException($errorTitle, $status);
		} elseif ($status >= 500 && $status < 600) {
			$e = new ServerException($errorTitle, $status);
		} else {
			$e = new ServerException('Unexpected HTTP Status Code: '.$status, $status);
		}

		return $e;
	}

}
