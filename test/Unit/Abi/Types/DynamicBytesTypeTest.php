<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\DynamicBytes;
use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class DynamicBytesTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'bytes',
            'result' => true
        ], [
            'value' => 'bytes[]',
            'result' => true
        ], [
            'value' => 'bytes[4]',
            'result' => true
        ], [
            'value' => 'bytes[][]',
            'result' => true
        ], [
            'value' => 'bytes[3][]',
            'result' => true
        ], [
            'value' => 'bytes[][6][]',
            'result' => true
        ], [
            'value' => 'bytes32',
            'result' => false
        ], [
            'value' => 'bytes8[4]',
            'result' => false
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
        $this->type = new DynamicBytes;
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
