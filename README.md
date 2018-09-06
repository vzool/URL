## RESTful Library using `file_get_contents` only

### install

```shell
composer require vzool/url
```

### Usage
```php
require_once __DIR__.'/vendor/autoload.php';

use Vzool\URL\URL;

$http = new URL('https://jsonplaceholder.typicode.com');

$result = $http->GET('/posts/1');

print_r($result->content()); // returns stdClass objects :)
print_r($result->toArray()); // returns array
print_r($result->toJson());  // returns raw response, I'm a JSON Patroit ;)
```
