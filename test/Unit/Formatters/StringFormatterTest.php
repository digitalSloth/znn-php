<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use DigitalSloth\ZnnPhp\Formatters\StringFormatter;
use DigitalSloth\ZnnPhp\Test\TestCase;

class StringFormatterTest extends TestCase
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
        $this->formatter = new StringFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat()
    {
        $formatter = $this->formatter;

        $str = $formatter->format(123456);
        $this->assertEquals($str, '123456');
    }
}
