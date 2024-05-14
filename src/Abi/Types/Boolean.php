<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use InvalidArgumentException;

class Boolean extends AbiType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^bool/', $name) === 1);
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
        if (! is_bool($value)) {
            throw new InvalidArgumentException('The value to inputFormat function must be boolean.');
        }

        $value = (int) $value;

        return '000000000000000000000000000000000000000000000000000000000000000' . $value;
    }

    /**
     * outputFormat
     *
     * @param mixed $value
     * @param string $name
     * @return bool
     */
    public function outputFormat(mixed $value, array $abiType): bool
    {
        $value = (int) mb_substr($value, 63, 1);

        return (bool) $value;
    }
}
