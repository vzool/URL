<?php

namespace Vzool\URL;

/**
 * RESTful Library using file_get_contents only
 * https://www.vzool.net
 * (c) Abdelaziz Elrashed <aeemh.sdn@gmail.com>
 */
class URL
{
	public $base_url;
	public $path; // URI
	public $headers;
	public $options;
	public $context;
	public $response;
	public $error;

	function __construct($base_url = 'http://localhost', $headers = ['Content-Type' => 'application/json; charset=UTF-8'])
	{
		$this->base_url = $base_url;
		$this->headers = $headers;
	}

	function __call($method, $args)
	{
		$allowed = [
			'GET', 'POST', 'PUT', 'PATCH',
			'DELETE', 'HEAD', 'OPTIONS',
		];

		if(preg_grep( "/{$method}/i" , $allowed)){
			return $this->execute($args[0], $method, $args[1] ?? '');
		}
		return false;
	}

	private function execute($path, $method='GET', $parameters = [])
	{
		$client = clone $this;

		$client->path = $path;

		$client->options = array($client->protocol() =>
			array(
				'method'  => $method,
				'header'  => $client->headers(),
				'content' => $parameters,
			)
		);

		if($client->base_url){
			if($client->path[0] != '/' && substr($client->base_url, -1) != '/')
				$client->path = '/' . $client->path;
			$client->path = $client->base_url . $client->path;
		}

		try{
			
			$client->context  = stream_context_create($client->options);
			$client->response = file_get_contents($client->path, false, $client->context);

		}catch(Exception $ex){
			$client->error = $ex;
		}

		return $client;
	}

	private function protocol()
	{
		$schema = explode('://', $this->base_url);
		return $schema[0];
	}

	private function headers()
	{
		$headers = [];

		foreach($this->headers as $key => $value){
			$headers []= "{$key}: {$value}";
		}

		return implode('\r\n', $headers);
	}

	public function toJson()
	{
		return $this->response;
	}

	public function toArray()
	{
		return $this->content(TRUE);
	}

	public function content($assoc = FALSE)
	{
		return json_decode($this->response, $assoc);
	}
}
