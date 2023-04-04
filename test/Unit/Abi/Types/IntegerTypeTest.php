<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\Integer;
use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class IntegerTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'int',
            'result' => true
        ], [
            'value' => 'int[]',
            'result' => true
        ], [
            'value' => 'int[4]',
            'result' => true
        ], [
            'value' => 'int[][]',
            'result' => true
        ], [
            'value' => 'int[3][]',
            'result' => true
        ], [
            'value' => 'int[][6][]',
            'result' => true
        ], [
            'value' => 'int32',
            'result' => true
        ], [
            'value' => 'int64[4]',
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
        $this->type = new Integer;
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
