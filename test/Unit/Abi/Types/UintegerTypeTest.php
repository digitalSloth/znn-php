<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Abi\Types\Uinteger;
use DigitalSloth\ZnnPhp\Test\TestCase;

class UintegerTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'uint',
            'result' => true
        ], [
            'value' => 'uint[]',
            'result' => true
        ], [
            'value' => 'uint[4]',
            'result' => true
        ], [
            'value' => 'uint[][]',
            'result' => true
        ], [
            'value' => 'uint[3][]',
            'result' => true
        ], [
            'value' => 'uint[][6][]',
            'result' => true
        ], [
            'value' => 'uint32',
            'result' => true
        ], [
            'value' => 'uint64[4]',
            'result' => true
        ], [
            'value' => 'uint64[4]',
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
        $this->type = new Uinteger;
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
