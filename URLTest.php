<?php

require_once __DIR__.'/vendor/autoload.php';

use Vzool\URL\URL;

$http = new URL('http://localhost:3003', [
	'Accept-language' => 'ar',
	'Authoriztion-X' => sha1(time()),
	'Created' => date('Y-m-d H:i:s'),
]);

$URI = "/customers/";

// POST

echo PHP_EOL . "----------------";
echo PHP_EOL . "POST:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->post($URI, [
  "name" => uniqid(),
]);

print_r($result->content());

$new_customer = $result->content();

// GET ALL

echo PHP_EOL . "----------------";
echo PHP_EOL . "GET ALL:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->get($URI);

print_r($result->content());

// GET ONE

echo PHP_EOL . "----------------";
echo PHP_EOL . "GET ONE:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->get($URI . $new_customer->id);

print_r($result->content());

// PUT

echo PHP_EOL . "----------------";
echo PHP_EOL . "PUT:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->put($URI . $new_customer->id, [
  "name" => $new_customer->name . "-" . uniqid(),
]);
print_r($result->content());

// DELETE

echo PHP_EOL . "----------------";
echo PHP_EOL . "DELETE:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->delete($URI . $new_customer->id);

// HEAD

echo PHP_EOL . "----------------";
echo PHP_EOL . "HEAD:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->head($URI);

// OPTIONS

echo PHP_EOL . "----------------";
echo PHP_EOL . "OPTIONS:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->options($URI);

print_r($result->content());
