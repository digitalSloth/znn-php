<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Abi\AbiType;
use DigitalSloth\ZnnPhp\Formatters\IntegerFormatter;


class BaseArray extends AbiType implements TypeInterface
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
        return true;
    }

    /**
     * encodeElements
     *
     * @param mixed $value
     * @param string $name
     * @return array
     */
    public function encodeElements(array $value, array $name): array
    {
        $results = [];
        $itemsAreDynamic = false;
        foreach ($value as $key => $val) {
            $results[] = $name['coders']['solidityType']->encode($val, $name['coders']);
            if ($name['coders']['dynamic']) {
                $itemsAreDynamic = true;
            }
        }
        if (!$itemsAreDynamic) {
            return $results;
        }
        $headLength = 32 * count($value);
        $tailOffsets = [0];
        foreach ($results as $key => $val) {
            if ($key === count($results) - 1) {
                break;
            }
            $tailOffsets[] = mb_strlen($val) / 2;
        }
        $headChunks = [];
        $totalOffset = 0;
        foreach ($tailOffsets as $offset) {
            $totalOffset += $offset;
            $headChunks[] = IntegerFormatter::format($headLength + $totalOffset);
        }
        return array_merge($headChunks, $results);
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
        return implode('', $this->encodeElements($value, $abiType));
    }

    /**
     * outputFormat
     *
     * @param mixed $value
     * @param array $abiType
     * @return string
     */
    // public function outputFormat($value, $abiType)
    // {
    //     throw new InvalidArgumentException('Should not call outputFormat in BaseArray directly');
    // }
}
