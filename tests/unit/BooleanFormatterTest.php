<?php

namespace DigitalSloth\ZnnPhp\Tests\Unit;

use InvalidArgumentException;
use DigitalSloth\ZnnPhp\Tests\TestCase;
use Web3\Formatters\BooleanFormatter;

class BooleanFormatterTest extends TestCase
{
    /**
     * formatter
     *
     * @var \Web3\Formatters\BooleanFormatter
     */
    protected $formatter;

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
    public function testFormat()
    {
        $formatter = $this->formatter;

        $boolean = $formatter->format(true);
        $this->assertEquals($boolean, true);

        $boolean = $formatter->format(1);
        $this->assertEquals($boolean, true);

        $boolean = $formatter->format(false);
        $this->assertEquals($boolean, false);

        $boolean = $formatter->format(0);
        $this->assertEquals($boolean, false);
    }
}
