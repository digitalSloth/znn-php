<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Common extends Abi
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
            'name' => 'CollectReward',
            'inputs' => [],
        ],
    ];
}
