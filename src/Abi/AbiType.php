<?php

namespace DigitalSloth\ZnnPhp\Abi;

class AbiType
{
    public function nestedTypes(string $name): mixed
    {
        $matches = [];

        if (preg_match_all('/(\[[0-9]*\])/', $name, $matches, PREG_PATTERN_ORDER) >= 1) {
            return $matches[0];
        }

        return false;
    }

    public function nestedName(string $name): string
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            return $name;
        }
        return mb_substr($name, 0, mb_strlen($name) - mb_strlen($nestedTypes[count($nestedTypes) - 1]));
    }

    public function isDynamicArray(string $name): bool
    {
        $nestedTypes = $this->nestedTypes($name);

        return $nestedTypes && preg_match('/[0-9]{1,}/', $nestedTypes[count($nestedTypes) - 1]) !== 1;
    }

    public function isStaticArray(string $name): bool
    {
        $nestedTypes = $this->nestedTypes($name);

        return $nestedTypes && preg_match('/[0-9]{1,}/', $nestedTypes[count($nestedTypes) - 1]) === 1;
    }

    public function staticArrayLength(string $name): int
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            return 1;
        }

        $match = [];

        if (preg_match('/[0-9]{1,}/', $nestedTypes[count($nestedTypes) - 1], $match) === 1) {
            return (int) $match[0];
        }

        return 1;
    }

    public function isDynamicType(): bool
    {
        return false;
    }

    /**
     * deepCalculateDataLength
     * Calculate static data size recursively.
     * TODO: Improve this function, or calculate data length when parse abi.
     *
     * @param array $data
     * @return integer
     */
    public function deepCalculateDataLength($data)
    {
        if (!is_array($data)) {
            return 1;
        }

        $dataCount = 0;
        foreach ($data as $d) {
            if (is_array($d)) {
                $dataCount += $this->deepCalculateDataLength($d);
            } else {
                ++$dataCount;
            }
        }

        return $dataCount;
    }


    public function encode(mixed $value, array $abiType): array|string
    {
        return $this->inputFormat($value, $abiType);
    }

    public function decode(mixed $value, int $offset, array $abiTypes): mixed
    {
        $value = mb_substr($value, $offset);
        return $this->outputFormat($value, $abiTypes);
    }
}
