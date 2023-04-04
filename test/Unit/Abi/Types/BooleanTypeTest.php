<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\Boolean;
use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class BooleanTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'bool',
            'result' => true
        ], [
            'value' => 'bool[]',
            'result' => true
        ], [
            'value' => 'bool[4]',
            'result' => true
        ], [
            'value' => 'bool[][]',
            'result' => true
        ], [
            'value' => 'bool[3][]',
            'result' => true
        ], [
            'value' => 'bool[][6][]',
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
        $this->type = new Boolean;
    }

    /**
     * testIsType
     *
     * @return void
     */
    public function testIsType()
    {
        $typeClass = $this->type;

        foreach ($this->testTypes as $type) {
            $this->assertEquals($type['result'], $typeClass->isType($type['value']));
        }
    }
}
