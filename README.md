## A Simple RESTful HTTP Client Library using `file_get_contents` only
[![Latest Stable Version](https://poser.pugx.org/vzool/URL/version)](https://packagist.org/packages/vzool/URL)
[![License](https://poser.pugx.org/vzool/URL/license)](https://packagist.org/packages/vzool/URL)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vzool/URL/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vzool/URL/badges/quality-score.png?b=master)
[![Build Status](https://travis-ci.org/vzool/URL.svg?branch=master)](https://travis-ci.org/vzool/URL)

### Install

```shell
composer require vzool/url
```

### Usage
```php
require_once __DIR__.'/vendor/autoload.php';

use vzool\URL\URL;

$http = new URL('https://jsonplaceholder.typicode.com');

// to GET

$result = $http->GET('/posts/1');

// to POST

$result = $http->POST('/posts', [
  "title" => "Agreement",
  "body" => "Ha ha ha",
  "author" => "Aziz",
]);

// to PUT

$result = $http->PUT('/posts/1', [
  "title" => "Agreement #2",
]);

// to DELETE

$result = $http->DELETE('/posts/1');

// or

$result = $http->delete('/posts/1');

// to get result

print_r($result->content()); // returns stdClass objects :)
print_r($result->toArray()); // returns array
print_r($result->toJson());  // returns raw response, I'm a JSON Patriot ;)
```
