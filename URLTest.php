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

$result = $http->POST($URI, [
  "name" => uniqid(),
]);

print_r($result->content());

$new_customer = $result->content();

// GET ALL

echo PHP_EOL . "----------------";
echo PHP_EOL . "GET ALL:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->GET($URI);

print_r($result->content());

// GET ONE

echo PHP_EOL . "----------------";
echo PHP_EOL . "GET ONE:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->GET($URI . $new_customer->id);

print_r($result->content());

// PUT

echo PHP_EOL . "----------------";
echo PHP_EOL . "PUT:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->PUT($URI . $new_customer->id, [
  "name" => $new_customer->name . "-" . uniqid(),
]);
print_r($result->content());

// DELETE

echo PHP_EOL . "----------------";
echo PHP_EOL . "DELETE:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->DELETE($URI . $new_customer->id);

// HEAD

echo PHP_EOL . "----------------";
echo PHP_EOL . "HEAD:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->HEAD($URI);

// OPTIONS

echo PHP_EOL . "----------------";
echo PHP_EOL . "OPTIONS:";
echo PHP_EOL . "----------------" . PHP_EOL;

$result = $http->OPTIONS($URI);

print_r($result->content());
