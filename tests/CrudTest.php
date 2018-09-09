<?php

use vzool\URL\URL;
use PHPUnit\Framework\TestCase;
use donatj\MockWebServer\Response;
use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\ResponseStack;

class CrudTest extends TestCase
{
	private $http;
	private $url;
	private $server;

	protected function setUp()
	{
		$this->server = new MockWebServer;
		$this->server->start();

		$this->url = $this->server->getServerRoot();
		$this->http = new URL($this->url);
	}

	public function testGET()
	{
		$result = $this->http->get('/');
		
		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		// check type

		$this->assertInstanceOf(URL::class, $result);

		$this->assertInternalType(object::class, $result->response);
		
		$this->assertEquals(is_string($result->response->body), true);
		
		$this->assertInstanceOf(stdClass::class, $content);

		$this->assertEquals(is_array($content->_GET), true);

		$this->assertEquals(is_array($content->_POST), true);

		$this->assertEquals(is_array($content->_FILES), true);

		$this->assertEquals(is_array($content->_COOKIE), true);

		// check empty

		$this->assertEmpty($content->_GET);

		$this->assertEmpty($content->_POST);

		$this->assertEmpty($content->_FILES);

		$this->assertEmpty($content->_COOKIE);
		
		$this->assertInstanceOf(stdClass::class, $content->HEADERS);

		$this->assertEquals(is_array($content->PARSED_INPUT), true);

		$this->assertInstanceOf(stdClass::class, $content->PARSED_REQUEST_URI);
	}

	public function testGET_With_Parameters()
	{
		$key = uniqid('KEY-');
		$value = sha1($key);

		$result = $this->http->get("/?{$key}={$value}");
		
		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		// check type

		$this->assertInstanceOf(stdClass::class, $content->_GET);

		$this->assertEquals(is_array($content->_POST), true);

		$this->assertEquals(is_array($content->_FILES), true);

		$this->assertEquals(is_array($content->_COOKIE), true);

		// check empty

		$this->assertEmpty($content->_POST);

		$this->assertEmpty($content->_FILES);

		$this->assertEmpty($content->_COOKIE);

		// check sent data

		$this->assertEquals($content->_GET->{$key}, $value);
	}

	public function testPost()
	{
		$value = uniqid();

		$result = $this->http->post('/', [
		  "name" => $value,
		]);

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		$this->assertEquals($content->_POST->name, $value);

		$this->assertEquals($content->PARSED_INPUT->name, $value);
	}

	public function testPut()
	{
		$value = uniqid();

		$result = $this->http->put('/', [
		  "name" => $value,
		]);

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		$this->assertEquals(strtoupper($content->METHOD), 'PUT');

		$this->assertEquals($content->PARSED_INPUT->name, $value);
	}

	public function testHead()
	{
		$value = uniqid();

		$result = $this->http->head();

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);
	}

	public function testOptions()
	{
		$value = uniqid();

		$result = $this->http->options('/', [
		  "name" => $value,
		]);

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		$this->assertEquals(strtoupper($content->METHOD), 'OPTIONS');

		$this->assertEquals($content->PARSED_INPUT->name, $value);
	}

	public function testDelete()
	{
		$value = uniqid();

		$result = $this->http->delete('/', [
		  "name" => $value,
		]);

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		$this->assertEquals(strtoupper($content->METHOD), 'DELETE');

		$this->assertEquals($content->PARSED_INPUT->name, $value);
	}

	public function testHeaders(){

		$local_headers = [
			'Accept_language' => 'ar',
			'Authoriztion_X' => sha1(time()),
			'Created' => date('Y-m-d H:i:s'),
		];

		$http = new URL($this->url, $local_headers);

		$result = $http->get('/');

		$content = $result->content();

		$this->assertEquals($result->getStatusCode(), 200);

		// check header sent

		foreach ($local_headers as $key => $value) {

			$this->assertEquals($content->HEADERS->{$key}, $value);
		}
	}

	/*public function test_404(){

		$url = $this->server->getUrlOfResponse(
			new ResponseStack(
				new Response("Response One", [ 'X-Boop-Bat' => 'Sauce' ], 500),
				new Response("Response Two", [ 'X-Slaw-Dawg: FranCran' ], 400)
			)
		);

		$http = new URL($url);

		$result = $http->get('/');

		print_r($result);
	}*/
}
?>