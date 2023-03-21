<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Utilities;
use InvalidArgumentException;

class Bytes extends BaseType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^bytes([0-9]+)(\[([0-9]*)\])*$/', $name) === 1);
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
        if (! Utilities::isHex($value)) {
            throw new InvalidArgumentException('The value to inputFormat must be hex bytes.');
        }
        $value = Utilities::stripZero($value);

        if (mb_strlen($value) % 2 !== 0) {
            $value = "0" . $value;
        }

        if (mb_strlen($value) > 64) {
            throw new InvalidArgumentException('The value to inputFormat is too long.');
        }
        $l = floor((mb_strlen($value) + 63) / 64);
        $padding = (($l * 64 - mb_strlen($value) + 1) >= 0) ? $l * 64 - mb_strlen($value) : 0;

        return $value . implode('', array_fill(0, $padding, '0'));
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
        $checkZero = str_replace('0', '', $value);

        if (empty($checkZero)) {
            return '0';
        }
        if (preg_match('/^bytes([0-9]*)/', $name, $match) === 1) {
            $size = (int) $match[1];
            $length = 2 * $size;
            $value = mb_substr($value, 0, $length);
        }

        return '0x' . $value;
    }
}
