<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Abi\Types\Address;
use DigitalSloth\ZnnPhp\Test\TestCase;

class AddressTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected array $testTypes = [
        [
            'value' => 'address',
            'result' => true
        ], [
            'value' => 'address[]',
            'result' => true
        ], [
            'value' => 'address[4]',
            'result' => true
        ], [
            'value' => 'address[][]',
            'result' => true
        ], [
            'value' => 'address[3][]',
            'result' => true
        ], [
            'value' => 'address[][6][]',
            'result' => true
        ],
    ];

    /**
     * type
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
        $this->type = new Address;
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
            $this->assertEquals($typeClass->isType($type['value']), $type['result']);
        }
    }
}
