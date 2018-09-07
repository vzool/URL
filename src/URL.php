<?php

namespace Vzool\URL;

/**
 * A Simple RESTful HTTP Client Library using `file_get_contents` only
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

	function __construct($base_url = 'http://localhost', $headers = [])
	{
		$this->base_url = $base_url;
		$this->headers = $headers;

		return $this;
	}

	public static function __callStatic($method, $args)
	{
		$url = new self($args[0], isset($args[1]) ? $args[1] : []);

		return $url->{$method}('/', isset($args[2]) ? $args[2] : []);
	}

	function __call($method, $args = [''])
	{
		$allowed = [
			'GET', 'POST', 'PUT', 'PATCH',
			'DELETE', 'HEAD', 'OPTIONS',
		];

		$method = strtoupper($method);

		if(in_array($method, $allowed)) {
			return $this->execute($args[0], $method, isset($args[1]) ? $args[1] : []);
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
				'content' => $parameters ? http_build_query($parameters) : ''
			)
		);

		if($client->base_url) {
			if($client->path[0] != '/' && substr($client->base_url, -1) != '/')
				$client->path = '/' . $client->path;
			$client->path = $client->base_url . $client->path;
		}

		try {
			
			$client->context  = stream_context_create($client->options);
			
			$client->response = (object) [
				'body' => file_get_contents($client->path, false, $client->context),
				'headers' => $http_response_header,
			];

		}catch(\Exception $ex) {
			$client->error = $ex;
		}

		return $client;
	}

	private function protocol()
	{
		$schema = explode('://', $this->base_url);
		return isset($schema[0]) ? $schema[0] : 'http';
	}

	private function headers()
	{
		$headers = ['Content-type: application/x-www-form-urlencoded'];

		foreach($this->headers as $key => $value) {
			$headers []= "{$key}: {$value}";
		}

		return implode(PHP_EOL, $headers);
	}

	public function getStatusCode()
	{
		if(isset($this->response->headers)) {
			$sections = explode(' ', $this->response->headers[0]);
			return $sections[1];
		}
	}

	public function toJson()
	{
		return $this->response->body;
	}

	public function toArray()
	{
		return $this->content(TRUE);
	}

	public function content($assoc = FALSE)
	{
		return json_decode($this->response->body, $assoc);
	}
}
