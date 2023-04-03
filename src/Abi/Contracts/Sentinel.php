<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Sentinel extends Abi
{
    protected array $abi = [
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
    ];
}
