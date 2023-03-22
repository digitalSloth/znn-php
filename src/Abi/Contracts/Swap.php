<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Swap extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'RetrieveAssets',
            'inputs' => [
                [
                    'name' => 'publicKey',
                    'type' => 'string',
                ],
                [
                    'name' => 'signature',
                    'type' => 'string',
                ],
            ],
        ],
    ];
}
