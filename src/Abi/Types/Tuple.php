<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;
use DigitalSloth\ZnnPhp\Utilities;

class Tuple extends AbiType
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/(tuple)?\((.*)\)/', $name) === 1);
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
     * @param string $abiType
     * @return string
     */
    public function inputFormat(mixed $params, array $abiTypes): string
    {
        $rawHead = [];
        $tail = [];
        foreach ($abiTypes['coders'] as $key => $abiType) {
            if ($abiType['dynamic']) {
                $rawHead[] = null;
                $tail[] = $abiType['solidityType']->encode($params[$key], $abiType);
            } else {
                $rawHead[] = $abiType['solidityType']->encode($params[$key], $abiType);
                $tail[] = '';
            }
        }
        $headLength = 0;
        foreach ($rawHead as $head) {
            if (is_null($head)) {
                $headLength += 32;
                continue;
            }
            $headLength += (int) (mb_strlen($head) / 2);
        }
        $tailOffsets = [0];
        $totalOffset = 0;
        foreach ($tail as $key => $val) {
            if ($key === count($tail) - 1) {
                break;
            }
            $totalOffset += (int) (mb_strlen($val) / 2);
            $tailOffsets[] = $totalOffset;
        }
        $headChunks = [];
        foreach ($rawHead as $key => $head) {
            if (! array_key_exists($key, $tailOffsets)) {
                continue;
            }
            $offset = $tailOffsets[$key];
            if (is_null($head)) {
                $headChunks[] = IntegerFormatter::format($headLength + $offset);
                continue;
            }
            $headChunks[] = $head;
        }
        return implode('', array_merge($headChunks, $tail));
    }

    /**
     * outputFormat
     *
     * @param string $value
     * @param array $abiType
     * @return array
     */
    public function outputFormat(mixed $value, array $abiTypes): array
    {
        $results = [];
        $staticOffset = 0;
        foreach ($abiTypes['coders'] as $key => $abiType) {
            if ($abiType['dynamic']) {
                $startPosHex = mb_substr($value, $staticOffset, 64);
                $startPos = Utilities::hexToNumber($startPosHex);
                $staticOffset += 64;
                $results[] = $abiType['solidityType']->decode($value, $startPos * 2, $abiType);
            } else {
                $decoded = $abiType['solidityType']->decode($value, $staticOffset, $abiType);
                $dataCount = $this->deepCalculateDataLength($decoded);
                $staticOffset += 64 * $dataCount;
                $results[] = $decoded;
            }
        }
        return $results;
    }
}
