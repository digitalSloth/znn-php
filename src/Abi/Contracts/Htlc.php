<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Htlc extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'Create',
            'inputs' => [
                [
                    'name' => 'hashLocked',
                    'type' => 'address',
                ],
                [
                    'name' => 'expirationTime',
                    'type' => 'int64',
                ],
                [
                    'name' => 'hashType',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'keyMaxSize',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'hashLock',
                    'type' => 'bytes',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Reclaim',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Unlock',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'preimage',
                    'type' => 'bytes',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'DenyProxyUnlock',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'AllowProxyUnlock',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'htlcProxyUnlockInfo',
            'inputs' => [
                [
                    'name' => 'allowed',
                    'type' => 'bool',
                ],
            ],
        ],
    ];
}
