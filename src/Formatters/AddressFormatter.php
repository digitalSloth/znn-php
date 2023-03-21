<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;

class AddressFormatter implements FormatterInterface
{
    public static function format(mixed $value): string
    {
        $value = (string) $value;

        if (Utilities::isAddress($value)) {
            $value = mb_strtolower($value);

            if (Utilities::isZeroPrefixed($value)) {
                return $value;
            }
            return '0x' . $value;
        }
        $value = IntegerFormatter::format($value, 40);

        return '0x' . $value;
    }
}
