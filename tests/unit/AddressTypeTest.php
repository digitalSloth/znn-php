<?php

namespace DigitalSloth\ZnnPhp\Tests\Unit;

use DigitalSloth\ZnnPhp\Abi\Types\TypeInterface;
use DigitalSloth\ZnnPhp\Tests\TestCase;
use DigitalSloth\ZnnPhp\Abi\Types\Address;

class AddressTypeTest extends TestCase
{
    /**
     * testTypes
     *
     * @var array
     */
    protected $testTypes = [
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
    public function testIsType()
    {
        $typeClass = $this->type;

        foreach ($this->testTypes as $type) {
            $this->assertEquals($typeClass->isType($type['value']), $type['result']);
        }
    }
}
