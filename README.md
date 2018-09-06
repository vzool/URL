## RESTful Client Library using `file_get_contents` only

### Install

```shell
composer require vzool/url
```

### Usage
```php
require_once __DIR__.'/vendor/autoload.php';

use Vzool\URL\URL;

$http = new URL('https://jsonplaceholder.typicode.com');

// for GET
$result = $http->GET('/posts/1');

// for POST
$result = $http->POST('/posts', [
  "title" => "Agreement",
  "body" => "Ha ha ha",
  "author" => "Aziz",
]);

// for PUT
$result = $http->PUT('/posts/1', [
  "title" => "Agreement #2",
]);

// for DELETE
$result = $http->DELETE('/posts/1');

print_r($result->content()); // returns stdClass objects :)
print_r($result->toArray()); // returns array
print_r($result->toJson());  // returns raw response, I'm a JSON Patriot ;)
```
