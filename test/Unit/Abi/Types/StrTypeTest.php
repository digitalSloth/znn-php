<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\Str;
use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class StrTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'string',
            'result' => true
        ], [
            'value' => 'string[]',
            'result' => true
        ], [
            'value' => 'string[4]',
            'result' => true
        ], [
            'value' => 'string[][]',
            'result' => true
        ], [
            'value' => 'string[3][]',
            'result' => true
        ], [
            'value' => 'string[][6][]',
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
        $this->type = new Str;
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
