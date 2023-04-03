<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;

class NumberFormatter implements FormatterInterface
{
    public static function format(mixed $value): int
    {
        $value = Utilities::toString($value);
        $bn = Utilities::toBn($value);
        return (int) $bn->toString();
    }
}
