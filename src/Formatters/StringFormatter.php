<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;

class StringFormatter implements FormatterInterface
{
    public static function format(mixed $value): string
    {
        return Utilities::toString($value);
    }
}
