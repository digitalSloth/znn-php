<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Formatters\BigNumberFormatter;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;

class Uinteger extends AbiType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^uint([0-9]{1,})?/', $name) === 1);
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
        return BigNumberFormatter::format('0x' . mb_substr($value, 0, 64));
    }
}
