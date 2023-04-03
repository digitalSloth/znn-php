<?php

namespace DigitalSloth\ZnnPhp\Abi\Contracts;

use DigitalSloth\ZnnPhp\Abi\Abi;

class Bridge extends Abi
{
    protected array $abi = [
        [
            'type' => 'function',
            'name' => 'WrapToken',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'toAddress',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'UpdateWrapRequest',
            'inputs' => [
                [
                    'name' => 'id',
                    'type' => 'hash',
                ],
                [
                    'name' => 'signature',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetNetwork',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'contractAddress',
                    'type' => 'string',
                ],
                [
                    'name' => 'metadata',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'RemoveNetwork',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetTokenPair',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'tokenStandard',
                    'type' => 'tokenStandard',
                ],
                [
                    'name' => 'tokenAddress',
                    'type' => 'string',
                ],
                [
                    'name' => 'bridgeable',
                    'type' => 'bool',
                ],
                [
                    'name' => 'redeemable',
                    'type' => 'bool',
                ],
                [
                    'name' => 'owned',
                    'type' => 'bool',
                ],
                [
                    'name' => 'minAmount',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'feePercentage',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'redeemDelay',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'metadata',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetNetworkMetadata',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'metadata',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'RemoveTokenPair',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'tokenStandard',
                    'type' => 'tokenStandard',
                ],
                [
                    'name' => 'tokenAddress',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Halt',
            'inputs' => [
                [
                    'name' => 'signature',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Unhalt',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'Emergency',
            'inputs' => [],
        ],
        [
            'type' => 'function',
            'name' => 'ChangeTssECDSAPubKey',
            'inputs' => [
                [
                    'name' => 'pubKey',
                    'type' => 'string',
                ],
                [
                    'name' => 'oldPubKeySignature',
                    'type' => 'string',
                ],
                [
                    'name' => 'newPubKeySignature',
                    'type' => 'string',
                ],
            ],
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
            'name' => 'SetAllowKeyGen',
            'inputs' => [
                [
                    'name' => 'allowKeyGen',
                    'type' => 'bool',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetRedeemDelay',
            'inputs' => [
                [
                    'name' => 'redeemDelay',
                    'type' => 'uint64',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'SetBridgeMetadata',
            'inputs' => [
                [
                    'name' => 'metadata',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'UnwrapToken',
            'inputs' => [
                [
                    'name' => 'networkClass',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'chainId',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'transactionHash',
                    'type' => 'hash',
                ],
                [
                    'name' => 'logIndex',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'toAddress',
                    'type' => 'address',
                ],
                [
                    'name' => 'tokenAddress',
                    'type' => 'string',
                ],
                [
                    'name' => 'amount',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'signature',
                    'type' => 'string',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'RevokeUnwrapRequest',
            'inputs' => [
                [
                    'name' => 'transactionHash',
                    'type' => 'hash',
                ],
                [
                    'name' => 'logIndex',
                    'type' => 'uint32',
                ],
            ],
        ],
        [
            'type' => 'function',
            'name' => 'Redeem',
            'inputs' => [
                [
                    'name' => 'transactionHash',
                    'type' => 'hash',
                ],
                [
                    'name' => 'logIndex',
                    'type' => 'uint32',
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
            'name' => 'SetOrchestratorInfo',
            'inputs' => [
                [
                    'name' => 'windowSize',
                    'type' => 'uint64',
                ],
                [
                    'name' => 'keyGenThreshold',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'confirmationsToFinality',
                    'type' => 'uint32',
                ],
                [
                    'name' => 'estimatedMomentumTime',
                    'type' => 'uint32',
                ],
            ],
        ],
    ];
}
