<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Utilities;
use InvalidArgumentException;


class SizedArray extends BaseArray
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/(\[([0-9]*)\])/', $name) === 1);
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
     * @param array $abiType
     * @return string
     */
    public function inputFormat(mixed $value, array $abiType): string
    {
        $length = $this->staticArrayLength($abiType['type']);

        if ($length === 0 || count($value) > $length) {
            throw new InvalidArgumentException('Invalid value to encode sized array, expected: ' . $length . ', but got ' . count($value));
        }

        return parent::inputFormat($value, $abiType);
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
        $length = $this->staticArrayLength($abiType['type']);
        $offset = 0;
        $results = [];
        $decoder = $abiType['coders'];
        for ($i = 0; $i < $length; $i++) {
            $decodeValueOffset = $offset;
            if ($decoder['dynamic']) {
                $decodeValueOffsetHex = mb_substr($value, $offset, 64);
                $decodeValueOffset = Utilities::hexToNumber($decodeValueOffsetHex) * 2;
            }
            $decoded = $decoder['solidityType']->decode($value, $decodeValueOffset, $decoder);
            $results[] = $decoded;
            $dataCount = 1;
            if (! $decoder['dynamic']) {
                $dataCount = $this->deepCalculateDataLength($decoded);
            }
            $offset += (64 * $dataCount);
        }
        return $results;
    }
}
