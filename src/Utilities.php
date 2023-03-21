<?php

namespace DigitalSloth\ZnnPhp;

use BitWasp\Bech32;
use BitWasp\Bech32\Exception\Bech32Exception;
use Elliptic\EdDSA;
use InvalidArgumentException;
use kornrunner\Keccak;
use phpseclib3\Math\BigInteger as BigNumber;
use stdClass;

class Utilities
{
    /**
     * SHA3_NULL_HASH
     */
    public const SHA3_NULL_HASH = 'c5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470';


    public static function addressFromPublicKey(string $publicKey): bool|string
    {
        $hrp = 'z';
        $hash = hash('sha3-256', hex2bin($publicKey), true);
        $binary = [0];

        // Convert hash to bytes array
        for ($i = 0, $iMax = strlen($hash); $i < $iMax; $i++) {
            $binary[] = ord($hash[$i]);
        }

        // Get first 20 array elements
        $digest = array_slice($binary, 0, 20);

        // bech32 and convert to address
        try {
            $bech32 = Bech32\convertBits($digest, count($digest), 8, 5);
        } catch (Bech32Exception $e) {
            return false;
        }

        return Bech32\encode($hrp, $bech32);
    }

    public static function verifySignedMessage(string $publicKey, string $message, string $signature): bool
    {
        $ec = new EdDSA('ed25519');
        try {
            $key = $ec->keyFromPublic($publicKey);
            $message = bin2hex(utf8_encode($message));
            return $key->verify($message, $signature);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function guessAbiMethod(string $data): ?array
    {
        $fingerprint = substr(self::toHex($data), 0, 8);

        $contracts = [
            'Accelerator' => Abi\Contracts\Accelerator::class,
            'Bridge' => Abi\Contracts\Bridge::class,
            'Common' => Abi\Contracts\Common::class,
            'Htlc' => Abi\Contracts\Htlc::class,
            'Pillar' => Abi\Contracts\Pillar::class,
            'Plasma' => Abi\Contracts\Plasma::class,
            'Sentinel' => Abi\Contracts\Sentinel::class,
            'Stake' => Abi\Contracts\Stake::class,
            'Token' => Abi\Contracts\Token::class,
        ];

        foreach ($contracts as $contract => $abiClass) {

            $abi = new $abiClass();
            $methods = $abi->getMethods();

            foreach ($methods as $method) {
                $methodFingerprint = $abi->getSignatureFingerprint($method);

                if ($fingerprint === $methodFingerprint) {
                    return [
                        'contract' => $contract,
                        'method' => $method,
                    ];
                }
            }
        }

        return null;
    }

    public static function getDataFingerprint(string $data): string
    {
        return substr(static::toHex($data), 0, 8);
    }





    /**
     * toHex
     * Encoding string or integer or numeric string(is not zero prefixed) or big number to hex.
     */
    public static function toHex(mixed $value, bool $isPrefix = false): string
    {
        if (is_numeric($value) && !is_string($value)) {
            // turn to hex number
            $bn = self::toBn($value);
            $hex = $bn->toHex(self::isNegative($value));
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        }

        if (is_string($value)) {
            $value = self::stripZero($value);
            $hex = implode('', unpack('H*', $value));
        }

        if ($value instanceof BigNumber) {
            $hex = $value->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        }

        if ($isPrefix) {
            return '0x'.$hex;
        }
        return $hex;
    }

    /**
     * hexToBin
     */
    public static function hexToBin(string $value): string
    {
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            $value = str_replace('0x', '', $value, $count);
        }
        return pack('H*', $value);
    }

    /**
     * isZeroPrefixed
     */
    public static function isZeroPrefixed(string $value): bool
    {
        return (str_starts_with($value, '0x'));
    }

    /**
     * stripZero
     */
    public static function stripZero(string $value): string
    {
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            return str_replace('0x', '', $value, $count);
        }
        return $value;
    }

    /**
     * isNegative
     */
    public static function isNegative(string $value): bool
    {
        return (str_starts_with($value, '-'));
    }

    /**
     * isAddress
     */
    public static function isAddress(string $value): bool
    {
        if (preg_match('/^(0x|0X)?[a-f0-9A-F]{40}$/', $value) !== 1) {
            return false;
        }

        if (preg_match('/^(0x|0X)?[a-f0-9]{40}$/', $value) === 1 || preg_match('/^(0x|0X)?[A-F0-9]{40}$/', $value) === 1) {
            return true;
        }

        return self::isAddressChecksum($value);
    }

    /**
     * isAddressChecksum
     */
    public static function isAddressChecksum(string $value): bool
    {
        $value = self::stripZero($value);
        $hash = self::stripZero(self::sha3(mb_strtolower($value)));

        for ($i = 0; $i < 40; $i++) {
            if (
                (intval($hash[$i], 16) > 7 && mb_strtoupper($value[$i]) !== $value[$i]) ||
                (intval($hash[$i], 16) <= 7 && mb_strtolower($value[$i]) !== $value[$i])
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * toChecksumAddress
     */
    public static function toChecksumAddress(string $value): string
    {
        $value = self::stripZero(strtolower($value));
        $hash = self::stripZero(self::sha3($value));
        $ret = '0x';

        for ($i = 0; $i < 40; $i++) {
            if (intval($hash[$i], 16) >= 8) {
                $ret .= strtoupper($value[$i]);
            } else {
                $ret .= $value[$i];
            }
        }
        return $ret;
    }

    /**
     * isHex
     */
    public static function isHex(string $value): bool
    {
        return (preg_match('/^(0x)?[a-f0-9]*$/', $value) === 1);
    }

    /**
     * sha3
     * keccak256
     */
    public static function sha3(string $value): ?string
    {
        if (str_starts_with($value, '0x')) {
            $value = self::hexToBin($value);
        }

        $hash = Keccak::hash($value, 256);

        if ($hash === self::SHA3_NULL_HASH) {
            return null;
        }

        return '0x' . $hash;
    }

    /**
     * toString
     */
    public static function toString(mixed $value): string
    {
        return (string) $value;
    }

    /**
     * jsonMethodToString
     */
    public static function jsonMethodToString(stdClass|array $json): string
    {
        if ($json instanceof stdClass) {
            // one way to change whole json stdClass to array type
            // $jsonString = json_encode($json);

            // if (JSON_ERROR_NONE !== json_last_error()) {
            //     throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
            // }
            // $json = json_decode($jsonString, true);

            // another way to change whole json to array type but need the depth
            // $json = self::jsonToArray($json, $depth)

            // another way to change json to array type but not whole json stdClass
            $json = (array) $json;
            $typeName = [];

            foreach ($json['inputs'] as $param) {
                if (isset($param->type)) {
                    $typeName[] = $param->type;
                }
            }
            return $json['name'] . '(' . implode(',', $typeName) . ')';
        }

        if (isset($json['name']) && strpos($json['name'], '(') > 0) {
            return $json['name'];
        }

        $typeName = [];

        foreach ($json['inputs'] as $param) {
            if (isset($param['type'])) {
                $typeName[] = $param['type'];
            }
        }

        return $json['name'] . '(' . implode(',', $typeName) . ')';
    }

    /**
     * jsonToArray
     */
    public static function jsonToArray(stdClass|array $json): array
    {
        if ($json instanceof stdClass) {
            $json = (array) $json;

            foreach ($json as $key => $param) {
                if (is_array($param)) {
                    foreach ($param as $subKey => $subParam) {
                        $json[$key][$subKey] = self::jsonToArray($subParam);
                    }
                } elseif ($param instanceof stdClass) {
                    $json[$key] = self::jsonToArray($param);
                }
            }
        } elseif (is_array($json)) {
            foreach ($json as $key => $param) {
                if (is_array($param)) {
                    foreach ($param as $subKey => $subParam) {
                        $json[$key][$subKey] = self::jsonToArray($subParam);
                    }
                } elseif ($param instanceof stdClass) {
                    $json[$key] = self::jsonToArray($param);
                }
            }
        }
        return $json;
    }

    /**
     * toBn
     * Change number or number string to bignumber.
     */
    public static function toBn(BigNumber|string|int $number): array|BigNumber
    {
        if ($number instanceof BigNumber){
            $bn = $number;
        } elseif (is_int($number)) {
            $bn = new BigNumber($number);
        } elseif (preg_match('/^(-{0,1})[0-9]*$/', $number)) {
            $number = (string) $number;

            if (self::isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if (strpos($number, '.') > 0) {
                $comps = explode('.', $number);

                if (count($comps) > 2) {
                    throw new InvalidArgumentException('toBn number must be a valid number.');
                }

                [$whole, $fraction] = $comps;

                return [
                    new BigNumber($whole),
                    new BigNumber($fraction),
                    strlen($comps[1]),
                    $negative1 ?? false
                ];
            }

            $bn = new BigNumber($number);
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } elseif (is_string($number)) {
            $number = mb_strtolower($number);

            if (self::isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if (self::isZeroPrefixed($number) || preg_match('/^[0-9a-f]+$/i', $number) === 1) {
                $number = self::stripZero($number);
                $bn = new BigNumber($number, 16);
            } elseif (empty($number)) {
                $bn = new BigNumber(0);
            } else {
                throw new InvalidArgumentException('toBn number must be valid hex string.');
            }
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } else {
            throw new InvalidArgumentException('toBn number must be BigNumber, string or int.');
        }

        return $bn;
    }

    public static function leftPadBytes(string $bytes, int $size): string
    {
        if (strlen($bytes) >= $size) {
            return $bytes;
        }
        return str_pad($bytes, $size, 0, STR_PAD_LEFT);
    }
}
