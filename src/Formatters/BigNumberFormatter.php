<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;

class BigNumberFormatter implements FormatterInterface
{
    public static function format(mixed $value): string
    {
        $value = Utilities::toString($value);
        return Utilities::toBn($value);
    }
}
