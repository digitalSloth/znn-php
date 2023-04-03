<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Liquidity extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Update',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Donate',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Fund',
            'inputs' => [
                [
                    'name' => 'znnReward',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'qsrReward',
                    'type' => 'uint256',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'BurnZnn',
            'inputs' => [
                [
                    'name' => 'burnAmount',
                    'type' => 'uint256',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetTokenTuple',
            'inputs' => [
                [
                    'name' => 'tokenStandards',
                    'type' => 'string[]',
                ],
                [
                    'name' => 'znnPercentages',
                    'type' => 'uint32[]',
                ],
                [
                    'name' => 'qsrPercentages',
                    'type' => 'uint32[]',
                ],
                [
                    'name' => 'minAmounts',
                    'type' => 'uint256[]',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'NominateGuardians',
            'inputs' => [
                [
                    'name' => 'guardians',
                    'type' => 'address[]',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'ProposeAdministrator',
            'inputs' => [
                [
                    'name' => 'address',
                    'type' => 'address',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Emergency',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'SetIsHalted',
            'inputs' => [
                [
                    'name' => 'isHalted',
                    'type' => 'bool',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'LiquidityStake',
            'inputs' => [
                [
                    'name' => 'durationInSec',
                    'type' => 'int64',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'CancelLiquidityStake',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'UnlockLiquidityStakeEntries',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'SetAdditionalReward',
            'inputs' => [
                [
                    'name' => 'znnReward',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'qsrReward',
                    'type' => 'uint256',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'CollectReward',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'ChangeAdministrator',
            'inputs' => [
                [
                    'name' => 'administrator',
                    'type' => 'address',
                ],
            ],
        ],
    ];
}
