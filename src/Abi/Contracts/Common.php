<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Common extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Update',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'CollectReward',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'DepositQsr',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'WithdrawQsr',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Donate',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'VoteByName',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'vote',
                    'type' => 'uint8',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'VoteByProdAddress',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'vote',
                    'type' => 'uint8',
                ],
            ],
        ],
    ];
}
