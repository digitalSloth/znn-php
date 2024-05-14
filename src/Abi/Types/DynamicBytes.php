<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Utilities;
use InvalidArgumentException;

class DynamicBytes extends AbiType implements TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^bytes(\[([0-9]*)\])*$/', $name) === 1);
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
    public function inputFormat(mixed $value, array $abiType): string
    {
        if (! Utilities::isHex($value)) {
            throw new InvalidArgumentException('The value to inputFormat must be hex bytes.');
        }

        $value = Utilities::stripZero($value);

        if (mb_strlen($value) % 2 !== 0) {
            $value = "0" . $value;
        }

        $bn = Utilities::toBn(floor(mb_strlen($value) / 2));
        $bnHex = $bn->toHex(true);
        $padded = mb_substr($bnHex, 0, 1);

        if ($padded !== '0' && $padded !== 'f') {
            $padded = '0';
        }

        $l = floor((mb_strlen($value) + 63) / 64);
        $padding = (($l * 64 - mb_strlen($value) + 1) >= 0) ? $l * 64 - mb_strlen($value) : 0;

        return implode('', array_fill(0, 64-mb_strlen($bnHex), $padded)) . $bnHex . $value . implode('', array_fill(0, $padding, '0'));
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
        $checkZero = str_replace('0', '', $value);

        if (empty($checkZero)) {
            return '0';
        }

        $size = (int) Utilities::toBn('0x' . mb_substr($value, 0, 64))->toString();
        $length = 2 * $size;

        return '0x' . mb_substr($value, 64, $length);
    }
}
