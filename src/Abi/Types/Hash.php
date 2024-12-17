<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;

class Hash extends AbiType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^hash/', $name) === 1);
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
     * to do: iban
     *
     * @param mixed $value
     * @param array $abiType
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
     * @param array $abiType
     * @return string
     */
    public function outputFormat(mixed $value, array $abiType): string
    {
	    return substr($value, 0, 64);
    }
}
