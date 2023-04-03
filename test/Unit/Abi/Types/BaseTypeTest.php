<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\Types\BaseType;
use DigitalSloth\ZnnPhp\Test\TestCase;

class BaseTypeTest extends TestCase
{
    /**
     * type
     *
     * @var BaseType
     */
    protected BaseType $type;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->type = new BaseType();
    }

    /**
     * testNestedTypes
     *
     * @return void
     */
    public function testNestedTypes(): void
    {
        $type = $this->type;

        $this->assertEquals(['[2]', '[3]', '[4]'], $type->nestedTypes('int[2][3][4]'));
        $this->assertEquals(['[2]', '[3]', '[]'], $type->nestedTypes('int[2][3][]'));
        $this->assertEquals(['[2]', '[3]'], $type->nestedTypes('int[2][3]'));
        $this->assertEquals(['[2]', '[]'], $type->nestedTypes('int[2][]'));
        $this->assertEquals(['[2]'], $type->nestedTypes('int[2]'));
        $this->assertEquals(['[]'], $type->nestedTypes('int[]'));
        $this->assertEquals(false, $type->nestedTypes('int'));

    }

    /**
     * testNestedName
     *
     * @return void
     */
    public function testNestedName(): void
    {
        $type = $this->type;

        $this->assertEquals('int[2][3]', $type->nestedName('int[2][3][4]'));
        $this->assertEquals('int[2][3]', $type->nestedName('int[2][3][]'));
        $this->assertEquals('int[2]', $type->nestedName('int[2][3]'));
        $this->assertEquals('int[2]', $type->nestedName('int[2][]'));
        $this->assertEquals('int', $type->nestedName('int[2]'));
        $this->assertEquals('int', $type->nestedName('int[]'));
        $this->assertEquals('int', $type->nestedName('int'));
    }

    /**
     * testIsDynamicArray
     *
     * @return void
     */
    public function testIsDynamicArray(): void
    {
        $type = $this->type;

        $this->assertFalse($type->isDynamicArray('int[2][3][4]'));
        $this->assertTrue($type->isDynamicArray('int[2][3][]'));
        $this->assertFalse($type->isDynamicArray('int[2][3]'));
        $this->assertTrue($type->isDynamicArray('int[2][]'));
        $this->assertFalse($type->isDynamicArray('int[2]'));
        $this->assertTrue($type->isDynamicArray('int[]'));
        $this->assertFalse($type->isDynamicArray('int'));
    }

    /**
     * testIsStaticArray
     *
     * @return void
     */
    public function testIsStaticArray(): void
    {
        $type = $this->type;

        $this->assertTrue($type->isStaticArray('int[2][3][4]'));
        $this->assertFalse($type->isStaticArray('int[2][3][]'));
        $this->assertTrue($type->isStaticArray('int[2][3]'));
        $this->assertFalse($type->isStaticArray('int[2][]'));
        $this->assertTrue($type->isStaticArray('int[2]'));
        $this->assertFalse($type->isStaticArray('int[]'));
        $this->assertFalse($type->isStaticArray('int'));
    }

    /**
     * testStaticArrayLength
     *
     * @return void
     */
    public function testStaticArrayLength(): void
    {
        $type = $this->type;

        $this->assertEquals(4, $type->staticArrayLength('int[2][3][4]'));
        $this->assertEquals(1, $type->staticArrayLength('int[2][3][]'));
        $this->assertEquals(3, $type->staticArrayLength('int[2][3]'));
        $this->assertEquals(1, $type->staticArrayLength('int[2][]'));
        $this->assertEquals(2, $type->staticArrayLength('int[2]'));
        $this->assertEquals(1, $type->staticArrayLength('int[]'));
        $this->assertEquals(1, $type->staticArrayLength('int'));

    }

    /**
     * testEncode
     *
     * @return void
     */
    // public function testEncode()
    // {
    //     $type = $this->type;
    //     $this->assertTrue(true);
    // }

    /**
     * testDecode
     *
     * @return void
     */
    // public function testDecode()
    // {
    //     $type = $this->type;
    //     $this->assertTrue(true);
    // }
}
