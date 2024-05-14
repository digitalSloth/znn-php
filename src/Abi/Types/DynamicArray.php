<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;
use DigitalSloth\ZnnPhp\Utilities;
use InvalidArgumentException;

class DynamicArray extends BaseArray
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/(\[\])/', $name) === 1);
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
     * @param array $abiType
     * @return string
     */
    public function inputFormat(mixed $value, array $abiType): string
    {
        $results = $this->encodeElements($value, $abiType);
        $encodeSize = IntegerFormatter::format(count($value));
        return $encodeSize . implode('', $results);
    }

    /**
     * outputFormat
     *
     * @param string $value
     * @param array $abiType
     * @return array
     */
    public function outputFormat(mixed $value, array $abiType): array
    {
        $lengthHex = mb_substr($value, 0, 64);
        $length = Utilities::hexToNumber($lengthHex);
        $offset = 0;
        $value = mb_substr($value, 64);
        $results = [];
        $decoder = $abiType['coders'];
        for ($i = 0; $i < $length; $i++) {
            $decodeValueOffset = $offset;
            if ($decoder['dynamic']) {
                $decodeValueOffsetHex = mb_substr($value, $offset, 64);
                $decodeValueOffset = Utilities::hexToNumber($decodeValueOffsetHex) * 2;
            }
            $results[] = $decoder['solidityType']->decode($value, $decodeValueOffset, $decoder);
            $offset += 64;
        }
        return $results;
    }
}
