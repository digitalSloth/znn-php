<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Ptlc extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Create',
            'inputs' => [
                [
                    'name' => 'expirationTime',
                    'type' => 'int64',
                ],
                [
                    'name' => 'pointType',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'pointLock',
                    'type' => 'bytes',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Reclaim',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Unlock',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'signature',
                    'type' => 'bytes',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'ProxyUnlock',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'destination',
                    'type' => 'address',
                ],
                [
                    'name' => 'signature',
                    'type' => 'bytes',
                ],
            ],
        ],
    ];
}
