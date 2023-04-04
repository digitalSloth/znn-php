<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\Bytes;
use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class BytesTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'bytes',
            'result' => false
        ], [
            'value' => 'bytes[]',
            'result' => false
        ], [
            'value' => 'bytes[4]',
            'result' => false
        ], [
            'value' => 'bytes[][]',
            'result' => false
        ], [
            'value' => 'bytes[3][]',
            'result' => false
        ], [
            'value' => 'bytes[][6][]',
            'result' => false
        ], [
            'value' => 'bytes32',
            'result' => true
        ], [
            'value' => 'bytes8[4]',
            'result' => true
        ],
    ];

    /**
     * solidityType
     *
     * @var TypeInterface
     */
    protected TypeInterface $type;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->type = new Bytes;
    }

    /**
     * testIsType
     *
     * @return void
     */
    public function testIsType(): void
    {
        $typeClass = $this->type;

        foreach ($this->testTypes as $type) {
            $this->assertEquals($type['result'], $typeClass->isType($type['value']));
        }
    }
}
