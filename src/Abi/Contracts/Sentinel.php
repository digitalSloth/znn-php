<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Sentinel extends Abi
{
    protected array $abi = [
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
            'name' => 'Register',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Revoke',
            'inputs' => [],
        ],
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
    ];
}
