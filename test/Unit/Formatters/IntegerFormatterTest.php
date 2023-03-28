<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;
use DigitalSloth\ZnnPhp\Test\TestCase;

class IntegerFormatterTest extends TestCase
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
        $this->formatter = new IntegerFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = $this->formatter;

        $hex = $formatter->format('1');
        $this->assertEquals($hex, implode('', array_fill(0, 63, '0')) . '1');

        $hex = $formatter->format('-1');
        $this->assertEquals($hex, implode('', array_fill(0, 64, 'f')));

        $hex = $formatter->format('ae');
        $this->assertEquals($hex, implode('', array_fill(0, 62, '0')) . 'ae');

        $hex = $formatter->format('1', 20);
        $this->assertEquals($hex, implode('', array_fill(0, 19, '0')) . '1');

        $hex = $formatter->format(48);
        $this->assertEquals($hex, implode('', array_fill(0, 62, '0')) . '30');

        $hex = $formatter->format('48');
        $this->assertEquals($hex, implode('', array_fill(0, 62, '0')) . '30');
    }
}
