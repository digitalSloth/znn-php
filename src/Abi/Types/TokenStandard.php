<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use DigitalSloth\ZnnPhp\Utilities;
use function BitWasp\Bech32\convertBits;
use function BitWasp\Bech32\decode;
use function BitWasp\Bech32\encode;

class TokenStandard extends Integer
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool
    {
        return (preg_match('/^tokenStandard(\[([0-9]*)\])*$/', $name) === 1);
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
     * @param string $name
     * @return string
     */
    public function inputFormat(mixed $value, string $name): string
    {
        $value = decode($value)[1];
        $value = convertBits($value, count($value),5, 8, false);
        $value = array_pad($value, -32, 0);
        $value = array_map('chr', $value);
        $value = implode($value);

        return Utilities::toHex($value);
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
        $token = mb_substr($value, 24, 40);
        $bytes = pack('H*', $token);
        $bytes = array_map('ord', str_split($bytes));
        $digest = array_slice($bytes, 10, 10);
        $bech32 = convertBits($digest, count($digest), 8, 5);

        return encode('zts', $bech32);
    }
}
