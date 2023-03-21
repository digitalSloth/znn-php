<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;

class IntegerFormatter implements FormatterInterface
{
    public static function format(mixed $value): string
    {
        $value = (string) $value;
        $arguments = func_get_args();
        $digit = 64;

        if (isset($arguments[1]) && is_numeric($arguments[1])) {
            $digit = (int)$arguments[1];
        }
        $bn = Utilities::toBn($value);
        $bnHex = $bn->toHex(Utilities::isNegative($value));
        $padded = mb_substr($bnHex, 0, 1);

        if ($padded !== 'f') {
            $padded = '0';
        }

        return implode('', array_fill(0, $digit-mb_strlen($bnHex), $padded)) . $bnHex;
    }
}
