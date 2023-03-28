<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use phpseclib3\Math\BigInteger as BigNumber;
use DigitalSloth\ZnnPhp\Formatters\BigNumberFormatter;
use DigitalSloth\ZnnPhp\Test\TestCase;

class BigNumberFormatterTest extends TestCase
{
    /**
     * formatter
     *
     * @var FormatterInterface
     */
    protected FormatterInterface $formatter;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->formatter = new BigNumberFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = $this->formatter;

        $bigNumber = $formatter->format(1);
        $this->assertEquals('1', $bigNumber->toString());
        $this->assertInstanceOf(BigNumber::class, $bigNumber);
    }
}
