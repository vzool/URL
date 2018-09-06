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
