# znn-php

The ZNN-PHP package allows you to read the JSON-RPC endpoints of the [zenon.network](https://zenon.community/) as described [here](https://github.com/zenon-network/znn-wiki/blob/master/api.md). It also provides methods for working with the ABI data.

- [X] RPC Endpoints
- [X] ABI Decoding
- [X] ABI Encoding
- [ ] Wallet & Keyfile support
- [ ] Unit tests

Wallet and keyfile support is still a work in progress. PRs are welcome :)

## Requirements

PHP 8.2 and later.

```
composer require digitalsloth/znn-php
```

## Usage

### RPC Setup
 - **Node Url** - By default, it will try and connect to a local node `127.0.0.1:35997` but you can pass in any public node URL. 
 - **Throw Errors** - You can choose to throw errors or not, defaults to `false`

Create a new instance of `$znn` calling the provider and method you want. All `accelerator`, `pillar`, `plasma`, `sentinel`, `stake`, `swap` , `token`, `ledger` and `stats` endpoints listed [here](https://github.com/zenon-network/znn-wiki/blob/master/api.md#embedded-smart-contracts) can be reached through the `$znn` instance.
```php
// config
$nodeUrl = 'https://node.zenonhub.io:35997';
$throwErrors = true;

// zenon client
$znn = new \DigitalSloth\ZnnPhp\Zenon($nodeUrl, $throwErrors);

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

### ABI Encoding/Decoding
Create a new instance of a `$contract` to access the encode and decode methods:
```php
// pick a contract to work with
$contract = new \DigitalSloth\ZnnPhp\Abi\Contracts\Accelerator();

$result = $contract->encode('CreateProject', ["Test", "Test", "Test.com", 1000000000, 10000000000]);
$result = base64_encode($result); // d8BEtgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA7msoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlQL5AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABFRlc3QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARUZXN0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIVGVzdC5jb20AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=


$result = $contract->decode('CreateProject', base64_decode('d8BEtgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA7msoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlQL5AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABFRlc3QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARUZXN0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIVGVzdC5jb20AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA='));
var_dump($result); // ["Test","Test","Test.com","1000000000","10000000000"]
```
