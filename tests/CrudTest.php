<?php

use Vzool\URL\URL;
use PHPUnit\Framework\TestCase;
use donatj\MockWebServer\MockWebServer;

class CrudTest extends TestCase
{
	private $http;

	protected function setUp()
	{
		$server = new MockWebServer;
		$server->start();

		$this->http = new URL($server->getServerRoot());
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
}
?>