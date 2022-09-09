<?php

namespace DigitalSloth\ZnnPhp\Abi;

class Stake extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Stake',
            'inputs' => [
                [
                    'name' => 'durationInSec',
                    'type' => 'int64',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Cancel',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
            ],
        ],
    ];
}
