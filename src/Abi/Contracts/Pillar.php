<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Pillar extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Update',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Register',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'producerAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'rewardAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'giveBlockRewardPercentage',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'giveDelegateRewardPercentage',
                    'type' => 'uint8',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'RegisterLegacy',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'producerAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'rewardAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'giveBlockRewardPercentage',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'giveDelegateRewardPercentage',
                    'type' => 'uint8',
                ],
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
        [
            'type' => 'function',
            'name' => 'UpdatePillar',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'producerAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'rewardAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'giveBlockRewardPercentage',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'giveDelegateRewardPercentage',
                    'type' => 'uint8',
                ],
            ],
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
            'name' => 'Revoke',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Delegate',
            'inputs' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Undelegate',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'CollectReward',
            'inputs' => [],
        ],
    ];
}
