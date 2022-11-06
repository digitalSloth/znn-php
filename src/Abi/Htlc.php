<?php

namespace DigitalSloth\ZnnPhp\Abi;

class Htlc extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'CreateHtlc',
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
            'name' => 'ReclaimHtlc',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'UnlockHtlc',
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
            'name' => 'htlcInfo',
            'inputs' => [
                [
                    'name' => 'timeLocked',
                    'type' => 'address',
                ],
                [
                    'name' => 'hashLocked',
                    'type' => 'address',
                ],
                [
                    'name' => 'tokenStandard',
                    'type' => 'tokenStandard',
                ],
                [
                    'name' => 'amount',
                    'type' => 'uint256',
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
    ];
}
