# Початок роботи
Ця бібліотека створена для спрощення використання API Syrve.

## Вимоги

Для коректної роботи бібліотеки потрібно встановити PHP версії 7.3 або вище.

## Встановлення
Встановіть бібліотеку за допомогою Composer:
```bash
composer require slothws/syrve-api
```
## Основи
Ось приклад простого використання бібліотеки. Давайте спробуємо отримати інформацію про співробітника за допомогою його унікального ідентифікатора (UUID).
```php
require __DIR__ . '/vendor/autoload.php';

use Sloth\SyrveApi\Syrve;

$syrve = new Syrve([
    'uri' => 'https://test.com/resto/api/',
    'login' => 'test',
    'password' => 'test'
]);

$employee = $syrve->employees->id('b8164def-74a7-471d-bb61-d612193f428b');
```
Відповідь отримуємо у вигляді масива даних.
```php
$employee = [
    'id' => 'b8164def-74a7-471d-bb61-d612193f428b',
    'code' => '1',
    'name' => 'Test',
    'login' => 'Test',
    'mainRoleCode' => 'USER',
    'roleCodes' => 'USER',
    'deleted' => 'false',
    'supplier' => 'false',
    'employee' => 'true',
    'client' => 'false'
]
```