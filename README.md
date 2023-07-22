# syrve-api
PHP library for convenient interaction with Syrve API.

## Requirements
PHP 7.3.0 and later.

## Installation
Via Composer
```bash
composer require slothws/syrve-api
```
## Basic Example
Initialization
```php
require __DIR__ . '/vendor/autoload.php';

use Sloth\SyrveApi\Syrve;

$syrve = new Syrve([
    'uri' => 'https://test.com/resto/api/',
    'login' => 'test',
    'password' => 'test'
]);
```

Get a list of employees.
```php
$response = $syrve->employees->list();
```

## Documentation
Read [Documentation](https://vpetrenko376.github.io/syrve-api/)

## License

[MIT](https://github.com/VPetrenko376/syrve-api/blob/main/LICENSE)