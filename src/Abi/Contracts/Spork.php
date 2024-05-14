<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Spork extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'CreateSpork',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ], [
                    'name' => 'description',
                    'type' => 'string',
                ]
            ],
        ],
        [
            'type' => 'function',
            'name' => 'ActivateSpork',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ]
            ],
        ],
    ];
}
