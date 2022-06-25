# znn-php

The ZNN-PHP package provides access to the read-only JSON-RPC endpoints of the [zenon.network](https://zenon.network/) as described [here](https://github.com/zenon-network/znn-wiki/blob/master/api.md).

## Requirements

PHP 7.4 and later.

```
composer require digitalsloth/znn-php
```

## Usage

### Setup
 - **Node Url** - By default, it will try and connect to a local node `127.0.0.1:35997` but you can pass in any public node URL. 
 - **Throw Errors** - You can choose to throw errors or not, defaults to `false`

```php
// config
$nodeUrl = 'ws://public.deeZNNodez.com:35998';
$throwErrors = true;

// zenon client
$znn = new \DigitalSloth\ZnnPhp\Zenon($nodeUrl, $throwErrors);
```

### Loading data
Once you have your `$znn` instance you can make requests:

```php
// load all pillars
$result = $znn->pillar->getAll();

if (! $result['status']) {
    die('Error loading data');
}

echo $result['data']->count;

foreach ($result['data']->list as $pillar) {
    var_dump($pillar);
}
```

All `accelerator`, `pillar`, `plasma`, `sentinel`, `stake`, `swap` , `token`, `ledger` and `stats` endpoints listed [here](https://github.com/zenon-network/znn-wiki/blob/master/api.md#embedded-smart-contracts) can be reached through the `$znn` instance.
