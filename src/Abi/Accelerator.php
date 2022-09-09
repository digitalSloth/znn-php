<?php

namespace DigitalSloth\ZnnPhp\Abi;

class Accelerator extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'CreateProject',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'description',
                    'type' => 'string',
                ],
                [
                    'name' => 'url',
                    'type' => 'string',
                ],
                [
                    'name' => 'znnFundsNeeded',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'qsrFundsNeeded',
                    'type' => 'uint256',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'AddPhase',
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
                    'name' => 'description',
                    'type' => 'string',
                ],
                [
                    'name' => 'url',
                    'type' => 'string',
                ],
                [
                    'name' => 'znnFundsNeeded',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'qsrFundsNeeded',
                    'type' => 'uint256',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'UpdatePhase',
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
                    'name' => 'description',
                    'type' => 'string',
                ],
                [
                    'name' => 'url',
                    'type' => 'string',
                ],
                [
                    'name' => 'znnFundsNeeded',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'qsrFundsNeeded',
                    'type' => 'uint256',
                ],
            ],
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
