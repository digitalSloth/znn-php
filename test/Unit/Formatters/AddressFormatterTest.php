<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Formatters;

use DigitalSloth\ZnnPhp\Formatters\AddressFormatter;
use DigitalSloth\ZnnPhp\Formatters\FormatterInterface;
use DigitalSloth\ZnnPhp\Test\TestCase;

class AddressFormatterTest extends TestCase
{
    /**
     * formatter
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
        $this->formatter = new AddressFormatter;
    }

    /**
     * testFormat
     *
     * @return void
     */
    public function testFormat(): void
    {
        $formatter = $this->formatter;

        $address = $formatter->format('z1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqsggv2f');
        $this->assertEquals('z1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqsggv2f', $address);

        $address = $formatter->format('z1qxemdeddedxplasmaxxxxxxxxxxxxxxxxsctrp');
        $this->assertEquals('z1qxemdeddedxplasmaxxxxxxxxxxxxxxxxsctrp', $address);

        $address = $formatter->format('z1qqslnf593pwpqrg5c29ezeltl8ndsrdep6yvmm');
        $this->assertEquals('z1qqslnf593pwpqrg5c29ezeltl8ndsrdep6yvmm', $address);
    }
}
