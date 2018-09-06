<?php

require_once __DIR__.'/vendor/autoload.php';

use Vzool\URL\URL;

$http = new URL('https://jsonplaceholder.typicode.com', [
	'Content-Type' => 'application/json; charset=UTF-8',
]);

$result = $http->GET('/posts/1');

print_r($result);
