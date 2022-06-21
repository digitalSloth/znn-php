# znn-php

The ZNN-PHP package provides access to the JSON-RPC endpoints of the [zenon.network](https://zenon.network/) as described [here](https://github.com/zenon-network/znn-wiki/blob/master/api.md).

## Requirements

PHP 7.4 and later.

```
composer require digitalsloth/znn-php
```

## Usage

```php
$znn = new \DigitalSloth\ZnnPhp\Zenon('127.0.0.1:35997');

try {
    $result = $znn->pillar->getAll();
} catch (\DigitalSloth\ZnnPhp\Exceptions\HttpException $e) {
    die($e->getMessage());
}

if (! $result['status']) {
    die('Error loading data');
}

echo $result['data']->count;

foreach ($result['data']->list as $pillar) {
    var_dump($pillar)
}
```
