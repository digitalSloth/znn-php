<?php

namespace DigitalSloth\ZnnPhp\Formatters;

use DigitalSloth\ZnnPhp\Utilities;
use phpseclib3\Math\BigInteger;

class BigNumberFormatter implements FormatterInterface
{
    public static function format(mixed $value): BigInteger|array
    {
        $value = Utilities::toString($value);
        return Utilities::toBn($value);
    }
}
