<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi;

use DigitalSloth\ZnnPhp\Abi\Handler;
use DigitalSloth\ZnnPhp\Abi\Types\Address;
use DigitalSloth\ZnnPhp\Abi\Types\Boolean;
use DigitalSloth\ZnnPhp\Abi\Types\Bytes;
use DigitalSloth\ZnnPhp\Abi\Types\DynamicArray;
use DigitalSloth\ZnnPhp\Abi\Types\DynamicBytes;
use DigitalSloth\ZnnPhp\Abi\Types\Hash;
use DigitalSloth\ZnnPhp\Abi\Types\Integer;
use DigitalSloth\ZnnPhp\Abi\Types\SizedArray;
use DigitalSloth\ZnnPhp\Abi\Types\Str;
use DigitalSloth\ZnnPhp\Abi\Types\TokenStandard;
use DigitalSloth\ZnnPhp\Abi\Types\Tuple;
use DigitalSloth\ZnnPhp\Abi\Types\Uinteger;
use DigitalSloth\ZnnPhp\Test\TestCase;

class HandlerTest extends TestCase
{
    /**
     * handler
     */
    protected Handler $handler;

    /**
     * encodingTests
     */
    protected $encodingTests = [
        [
            'params' => [['uint256','string'], ['2345675643', 'Hello!%']],
            'result' => '0x000000000000000000000000000000000000000000000000000000008bd02b7b0000000000000000000000000000000000000000000000000000000000000040000000000000000000000000000000000000000000000000000000000000000748656c6c6f212500000000000000000000000000000000000000000000000000'
        ],[
            'params' => [['uint8[]','bytes32'], [['34','434'], '0x324567dfff']],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000040324567dfff0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000002200000000000000000000000000000000000000000000000000000000000001b2'
        ], [
            'params' => [['bool[2]', 'bool[3]'], [[true, false], [false, false, true]]],
            'result' => '0x00000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001'
        ], [
            'params' => [['address'], ['z1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqsggv2f']],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000000'
        ], [
            'params' => [['int'], [1]],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000001'
        ], [
            'params' => [['int'], [16]],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000010'
        ], [
            'params' => [['int'], [-1]],
            'result' => '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
        ], [
            'params' => [['int256'], [1]],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000001'
        ], [
            'params' => [['int256'], [16]],
            'result' => '0x0000000000000000000000000000000000000000000000000000000000000010'
        ], [
            'params' => [['int256'], [-1]],
            'result' => '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
        ], [
            'params' => [['int[]'], [[3]]],
            'result' => '0x000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000003'
        ], [
            'params' => [['int256[]'], [[3]]],
            'result' => '0x000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000003'
        ], [
            'params' => [['int256[]'], [[1,2,3]]],
            'result' => '0x00000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000000003000000000000000000000000000000000000000000000000000000000000000100000000000000000000000000000000000000000000000000000000000000020000000000000000000000000000000000000000000000000000000000000003'
        ], [
            'params' => [['int[]','int[]'], [[1,2],[3,4]]],
            'result' => '0x000000000000000000000000000000000000000000000000000000000000004000000000000000000000000000000000000000000000000000000000000000a0000000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000002000000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000000030000000000000000000000000000000000000000000000000000000000000004'
        ]
    ];

    /**
     * decodingTests
     */
    protected $decodingTests = [
        [
            'params' => [['uint256'], '0x0000000000000000000000000000000000000000000000000000000000000010'],
            'result' => ['16']
        ], [
            'params' => [['string'], '0x0000000000000000000000000000000000000000000000000000000000000020000000000000000000000000000000000000000000000000000000000000000848656c6c6f212521000000000000000000000000000000000000000000000000'],
            'result' => ['Hello!%!']
        ], [
            'params' => [['uint256','string'], '0x000000000000000000000000000000000000000000000000000000008bd02b7b0000000000000000000000000000000000000000000000000000000000000040000000000000000000000000000000000000000000000000000000000000000748656c6c6f212500000000000000000000000000000000000000000000000000'],
            'result' => ['2345675643', 'Hello!%']
        ], [
            'params' => [['string'], '0x00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['']
        ], [
            'params' => [['int256'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0']
        ], [
            'params' => [['uint256'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0']
        ], [
            'params' => [['address'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['z1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqsggv2f']
        ], [
            'params' => [['bool'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => [false]
        ], [
            'params' => [['bytes'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0']
        ], [
            'params' => [['bytes32'], '0x0000000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0']
        ], [
            'params' => [['bytes32'], '0xdf32340000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0xdf32340000000000000000000000000000000000000000000000000000000000']
        ], [
            'params' => [['bytes32[]'], '0x00000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000000002df32340000000000000000000000000000000000000000000000000000000000fdfd000000000000000000000000000000000000000000000000000000000000'],
            'result' => ['0xdf32340000000000000000000000000000000000000000000000000000000000', '0xfdfd000000000000000000000000000000000000000000000000000000000000']
        ]
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->handler = new Handler([
            'address' => new Address,
            'bool' => new Boolean,
            'bytes' => new Bytes,
            'dynamicBytes' => new DynamicBytes,
            'hash' => new Hash,
            'int' => new Integer,
            'string' => new Str,
            'tokenStandard' => new TokenStandard,
            'uint' => new Uinteger,
            'sizedArray' => new SizedArray,
            'dynamicArray' => new DynamicArray,
            'tuple' => new Tuple,
        ]);
    }

    /**
     * testEncodeFunctionSignature
     *
     * @return void
     */
//    public function testEncodeFunctionSignature()
//    {
//        $abi = $this->handler;
//        $str = $abi->getMethodSignature('baz(uint32,bool)');
//        $this->assertEquals('0xcdcd77c0', $str);
//
//        $str = $abi->encodeFunctionSignature('bar(bytes3[2])');
//        $this->assertEquals('0xfce353f6', $str);
//
//        $str = $abi->encodeFunctionSignature('sam(bytes,bool,uint256[])');
//        $this->assertEquals('0xa5643bf2', $str);
//    }

    /**
     * testEncodeParameter
     *
     * @return void
     */
    public function testEncodeParameter()
    {
        $abi = $this->handler;

        $this->assertEquals(
            '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
            $abi->encodeParameter('int256', '-1')
        );
    }

    /**
     * testEncodeParameters
     *
     * @return void
     */
    public function testEncodeParameters()
    {
        $abi = $this->handler;

        foreach ($this->encodingTests as $test) {
            $this->assertEquals($test['result'], $abi->encodeParameters($test['params'][0], $test['params'][1]));
        }
    }

    /**
     * testDecodeParameter
     *
     * @return void
     */
    public function testDecodeParameter()
    {
        $abi = $this->handler;

        $this->assertEquals(
            '16',
            $abi->decodeParameter('uint256', '0x0000000000000000000000000000000000000000000000000000000000000010')
        );

        $this->assertEquals(
            '16',
            $abi->decodeParameter('uint256', '0x0000000000000000000000000000000000000000000000000000000000000010')
        );
    }

    /**
     * testDecodeParameters
     *
     * @return void
     */
    public function testDecodeParameters()
    {
        $abi = $this->handler;

        foreach ($this->decodingTests as $test) {
            $decoded = $abi->decodeParameters($test['params'][0], $test['params'][1]);

            foreach ($decoded as $key => $decoding) {
                if (!is_array($decoding)) {
                    $this->assertEquals($test['result'][$key], $decoding);
                } else {
                    foreach ($test['result'] as $rKey => $expected) {
                        $this->assertEquals($expected, $decoding[$rKey]);
                    }
                }
            }
        }
    }
}
