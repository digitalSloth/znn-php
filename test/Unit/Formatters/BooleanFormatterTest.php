<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use DigitalSloth\ZnnPhp\Formatters\BooleanFormatter;
use DigitalSloth\ZnnPhp\Test\TestCase;

class BooleanFormatterTest extends TestCase
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
        $this->formatter = new BooleanFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = $this->formatter;

        $boolean = $formatter->format(true);
        $this->assertEquals(true, $boolean);

        $boolean = $formatter->format(1);
        $this->assertEquals(true, $boolean);

        $boolean = $formatter->format(false);
        $this->assertEquals(false, $boolean);

        $boolean = $formatter->format(0);
        $this->assertEquals(false, $boolean);
    }
}
