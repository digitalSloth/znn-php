<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Formatters\BigNumberFormatter;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;
use DigitalSloth\ZnnPhp\Utilities;

class Str extends BaseType implements TypeInterface
{
    /**
     * construct
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^string(\[([0-9]*)\])*$/', $name) === 1);
    }

    /**
     * isDynamicType
     *
     * @return bool
     */
    public function isDynamicType(): bool
    {
        return true;
    }

    /**
     * inputFormat
     *
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function inputFormat(mixed $value, string $name): string
    {
        $value = Utilities::toHex($value);
        $prefix = IntegerFormatter::format(mb_strlen($value) / 2);
        $l = floor((mb_strlen($value) + 63) / 64);
        $padding = (($l * 64 - mb_strlen($value) + 1) >= 0) ? $l * 64 - mb_strlen($value) : 0;

        return $prefix . $value . implode('', array_fill(0, $padding, '0'));
    }

    /**
     * outputFormat
     *
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function outputFormat(mixed $value, string $name): string
    {
        $strLen = mb_substr($value, 0, 64);
        $strValue = mb_substr($value, 64);
        $match = [];

        if (preg_match('/^[0]+([a-f0-9]+)$/', $strLen, $match) === 1) {
            $strLen = BigNumberFormatter::format('0x' . $match[1])->toString();
        }

        $strValue = mb_substr($strValue, 0, (int) $strLen * 2);

        return Utilities::hexToBin($strValue);
    }
}
