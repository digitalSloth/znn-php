<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Plasma extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Fuse',
            'inputs' => [
                [
                    'name' => 'address',
                    'type' => 'address',
                ]
            ],
        ],
        [
            'type' => 'function',
            'name' => 'CancelFuse',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ]
            ],
        ],
    ];
}
