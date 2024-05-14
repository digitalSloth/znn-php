<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Formatters\BigNumberFormatter;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;

class Integer extends AbiType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^int([0-9]{1,})?/', $name) === 1);
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
    public function inputFormat(mixed $value, array $abiType): string
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
    public function outputFormat(mixed $value, array $abiType): string
    {
        $match = [];

        if (preg_match('/^[0]+([a-f0-9]+)$/', $value, $match) === 1) {
            // due to value without 0x prefix, we will parse as decimal
            $value = '0x' . $match[1];
        }

        return BigNumberFormatter::format($value);
    }
}
