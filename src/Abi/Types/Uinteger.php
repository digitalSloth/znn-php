<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;
use DigitalSloth\ZnnPhp\Formatters\BigNumberFormatter;

class Uinteger extends BaseType implements TypeInterface
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
        return (preg_match('/^uint([0-9]+)?(\[([0-9]*)\])*$/', $name) === 1);
    }

    /**
     * isDynamicType
     *
     * @return bool
     */
    public function isDynamicType(): bool
    {
        return false;
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
        return IntegerFormatter::format($value);
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
        $match = [];

        if (preg_match('/^([a-f0-9]+)$/', $value, $match) === 1) {
            $value = '0x' . $match[1];
        }

        return BigNumberFormatter::format($value);
    }
}
