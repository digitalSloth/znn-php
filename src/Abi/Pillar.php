<?php

namespace DigitalSloth\ZnnPhp\Abi;

class Pillar extends Abi
{
    protected array $abi = [
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
    ];
}
