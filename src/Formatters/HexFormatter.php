<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;

class HexFormatter implements FormatterInterface
{
    public static function format(mixed $value): string
    {
        $value = Utilities::toString($value);
        $value = mb_strtolower($value);

        if (Utilities::isZeroPrefixed($value)) {
            return $value;
        }

        return Utilities::toHex($value, true);
    }
}
