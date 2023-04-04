<?php

namespace DigitalSloth\ZnnPhp\Test\Unit;

use DigitalSloth\ZnnPhp\Test\TestCase;
use DigitalSloth\ZnnPhp\Utilities;
use phpseclib3\Math\BigInteger as BigNumber;

class UtilitiesTest extends TestCase
{
    /**
     * testHex
     * 'hello world'
     * you can check by call pack('H*', $hex)
     *
     * @var string
     */
    protected string $testHex = '68656c6c6f20776f726c64';

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * testToHex
     *
     * @return void
     */
    public function testToHex(): void
    {
        $this->assertEquals($this->testHex, Utilities::toHex('hello world'));
        $this->assertEquals('0x' . $this->testHex, Utilities::toHex('hello world', true));

        $this->assertEquals('0x927c0', Utilities::toHex(0x0927c0, true));
        //$this->assertEquals('0x927c0', Utilities::toHex('600000', true));
        $this->assertEquals('0x927c0', Utilities::toHex(600000, true));
        $this->assertEquals('0x927c0', Utilities::toHex(new BigNumber(600000), true));

        $this->assertEquals('0xea60', Utilities::toHex(0x0ea60, true));
        //$this->assertEquals('0xea60', Utilities::toHex('60000', true));
        $this->assertEquals('0xea60', Utilities::toHex(60000, true));
        $this->assertEquals('0xea60', Utilities::toHex(new BigNumber(60000), true));

        $this->assertEquals('0x', Utilities::toHex(0x00, true));
        //$this->assertEquals('0x', Utilities::toHex('0', true));
        $this->assertEquals('0x', Utilities::toHex(0, true));
        $this->assertEquals('0x', Utilities::toHex(new BigNumber(0), true));

        $this->assertEquals('0x30', Utilities::toHex(48, true));
        //$this->assertEquals('0x30', Utilities::toHex('48', true));
        $this->assertEquals('30', Utilities::toHex(48));
        //$this->assertEquals('30', Utilities::toHex('48'));

        $this->assertEquals('0x30', Utilities::toHex(new BigNumber(48), true));
        //$this->assertEquals('0x30', Utilities::toHex(new BigNumber('48'), true));
        $this->assertEquals('30', Utilities::toHex(new BigNumber(48)));
        $this->assertEquals('30', Utilities::toHex(new BigNumber('48')));
    }

    /**
     * testHexToBin
     *
     * @return void
     */
    public function testHexToBin(): void
    {
        $str = Utilities::hexToBin($this->testHex);
        $this->assertEquals('hello world', $str);

        $str = Utilities::hexToBin('0x' . $this->testHex);
        $this->assertEquals('hello world', $str);

        $str = Utilities::hexToBin('0xe4b883e5bda9e7a59ee4bb99e9b1bc');
        $this->assertEquals('七彩神仙鱼', $str);
    }

    /**
     * testIsZeroPrefixed
     *
     * @return void
     */
    public function testIsZeroPrefixed(): void
    {
        $str = Utilities::isZeroPrefixed($this->testHex);
        $this->assertFalse($str);

        $str = Utilities::isZeroPrefixed('0x' . $this->testHex);
        $this->assertTrue($str);
    }

    /**
     * testStripZero
     *
     * @return void
     */
    public function testStripZero(): void
    {
        $this->assertEquals($this->testHex, Utilities::stripZero($this->testHex));
        $this->assertEquals($this->testHex, Utilities::stripZero('0x' . $this->testHex));
    }

    /**
     * testIsNegative
     *
     * @return void
     */
    public function testIsNegative(): void
    {
        $isNegative = Utilities::isNegative('-1');
        $this->assertTrue($isNegative);

        $isNegative = Utilities::isNegative('1');
        $this->assertFalse($isNegative);
    }

    /**
     * testIsAddress
     *
     * @return void
     */
    public function testIsAddress(): void
    {
        $isAddress = Utilities::isAddress('ca35b7d915458ef540ade6068dfe2f44e8fa733c');
        $this->assertEquals(true, $isAddress);

        $isAddress = Utilities::isAddress('0xca35b7d915458ef540ade6068dfe2f44e8fa733c');
        $this->assertEquals(true, $isAddress);

        $isAddress = Utilities::isAddress('0Xca35b7d915458ef540ade6068dfe2f44e8fa733c');
        $this->assertEquals(true, $isAddress);

        $isAddress = Utilities::isAddress('0XCA35B7D915458EF540ADE6068DFE2F44E8FA733C');
        $this->assertEquals(true, $isAddress);

        $isAddress = Utilities::isAddress('0xCA35B7D915458EF540ADE6068DFE2F44E8FA733C');
        $this->assertEquals(true, $isAddress);

        $isAddress = Utilities::isAddress('0xCA35B7D915458EF540ADE6068DFE2F44E8FA73cc');
        $this->assertEquals(false, $isAddress);
    }

    /**
     * testIsHex
     *
     * @return void
     */
    public function testIsHex(): void
    {
        $isHex = Utilities::isHex($this->testHex);
        $this->assertTrue($isHex);

        $isHex = Utilities::isHex('0x' . $this->testHex);
        $this->assertTrue($isHex);

        $isHex = Utilities::isHex('hello world');
        $this->assertFalse($isHex);
    }

    /**
     * testSha3
     *
     * @return void
     */
    public function testSha3(): void
    {
        $str = Utilities::sha3('');
        $this->assertNull($str);

        $str = Utilities::sha3('baz(uint32,bool)');
        $this->assertEquals('af54f249a9', mb_substr($str, 0, 10));

        $str = Utilities::sha3('baz(uint32,bool)', true);
        $this->assertEquals('0xaf54f249a9', mb_substr($str, 0, 12));
    }

    /**
     * testToBn
     *
     * @return void
     */
    public function testToBn(): void
    {
        $bn = Utilities::toBn('');
        $this->assertEquals('0', $bn->toString());

        $bn = Utilities::toBn(11);
        $this->assertEquals('11', $bn->toString());

        $bn = Utilities::toBn('0x12');
        $this->assertEquals('18', $bn->toString());

        $bn = Utilities::toBn('-0x12');
        $this->assertEquals('-18', $bn->toString());

        $bn = Utilities::toBn(0x12);
        $this->assertEquals('18', $bn->toString());

        $bn = Utilities::toBn('ae');
        $this->assertEquals('174', $bn->toString());

        $bn = Utilities::toBn('-ae');
        $this->assertEquals('-174', $bn->toString());

        $bn = Utilities::toBn('-1');
        $this->assertEquals('-1', $bn->toString());

        $bn = Utilities::toBn('-0.1');
        $this->assertCount(4, $bn);
        $this->assertEquals('0', $bn[0]->toString());
        $this->assertEquals('1', $bn[1]->toString());
        $this->assertEquals(1, $bn[2]);
        $this->assertEquals('-1', $bn[3]->toString());

        $bn = Utilities::toBn(-0.1);
        $this->assertCount(4, $bn);
        $this->assertEquals('0', $bn[0]->toString());
        $this->assertEquals('1', $bn[1]->toString());
        $this->assertEquals(1, $bn[2]);
        $this->assertEquals('-1', $bn[3]->toString());

        $bn = Utilities::toBn('0.1');
        $this->assertCount(4, $bn);
        $this->assertEquals('0', $bn[0]->toString());
        $this->assertEquals('1', $bn[1]->toString());
        $this->assertEquals(1, $bn[2]);
        $this->assertEquals(false, $bn[3]);

        $bn = Utilities::toBn('-1.69');
        $this->assertCount(4, $bn);
        $this->assertEquals('1', $bn[0]->toString());
        $this->assertEquals('69', $bn[1]->toString());
        $this->assertEquals(2, $bn[2]);
        $this->assertEquals('-1', $bn[3]->toString());

        $bn = Utilities::toBn(-1.69);
        $this->assertEquals('1', $bn[0]->toString());
        $this->assertEquals('69', $bn[1]->toString());
        $this->assertEquals(2, $bn[2]);
        $this->assertEquals('-1', $bn[3]->toString());

        $bn = Utilities::toBn('1.69');
        $this->assertCount(4, $bn);
        $this->assertEquals('1', $bn[0]->toString());
        $this->assertEquals('69', $bn[1]->toString());
        $this->assertEquals(2, $bn[2]);
        $this->assertEquals(false, $bn[3]);

        $bn = Utilities::toBn(new BigNumber(1));
        $this->assertEquals('1', $bn->toString());
    }
}
