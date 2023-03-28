<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use DigitalSloth\ZnnPhp\Formatters\HexFormatter;
use DigitalSloth\ZnnPhp\Test\TestCase;

class HexFormatterTest extends TestCase
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
        $this->formatter = new HexFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = $this->formatter;

        $hex = $formatter->format('ae');
        $this->assertEquals('0x6165', $hex);

        $hex = $formatter->format('0xabce');
        $this->assertEquals('0xabce', $hex);

        $hex = $formatter->format('123');
        $this->assertEquals('0x313233', $hex);

        $hex = $formatter->format(12);
        $this->assertEquals('0x3132', $hex);
    }
}
