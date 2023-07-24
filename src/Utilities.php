<?php

namespace DigitalSloth\ZnnPhp;

use DigitalSloth\ZnnPhp\Model\Primitives\Address;
use DigitalSloth\ZnnPhp\Model\Primitives\Hash;
use DigitalSloth\ZnnPhp\Model\Primitives\TokenStandard;
use Elliptic\EdDSA;
use InvalidArgumentException;
use phpseclib3\Math\BigInteger as BigNumber;
use function BitWasp\Bech32\convertBits;

class Utilities
{
    public static function addressFromPublicKey(string $publicKey): bool|string
    {
        $publicKey = self::hexToBin($publicKey);
        $hash = Hash::digest($publicKey);
        $data = [0, ...$hash->core];
        $digest = array_slice($data, 0, 20);
        $bech32 = convertBits($digest, count($digest), 8, 5);
        return (new Address($bech32))->toString();
    }

    public static function ztsFromHash(string $hash): bool|string
    {
        $data = self::hexToBin($hash);
        $hash = Hash::digest($data);
        $data = array_slice($hash->core, 0, 10);
        $bech32 = convertBits($data, count($data), 8, 5);
        return (new TokenStandard($bech32))->toString();
    }

    /**
     * verifySignedMessage
     * Validates the message and signature checking they originated from given public key
     */
    public static function verifySignedMessage(string $publicKey, string $message, string $signature): bool
    {
        try {
            $ec = new EdDSA('ed25519');
            $key = $ec->keyFromPublic($publicKey);
            $message = bin2hex(mb_convert_encoding($message, 'UTF-8'));
            return $key->verify($message, $signature);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * guessAbiMethod
     * Attempts to guess the contract and method from a given data string.
     */
    public static function guessAbiMethod(string $data): ?array
    {
        $fingerprint = self::getDataFingerprint($data);

        $contracts = [
            'Accelerator' => Abi\Contracts\Accelerator::class,
            'Bridge' => Abi\Contracts\Bridge::class,
            'Common' => Abi\Contracts\Common::class,
            'Htlc' => Abi\Contracts\Htlc::class,
            'Liquidity' => Abi\Contracts\Liquidity::class,
            'Pillar' => Abi\Contracts\Pillar::class,
            'Plasma' => Abi\Contracts\Plasma::class,
            'Sentinel' => Abi\Contracts\Sentinel::class,
            'Stake' => Abi\Contracts\Stake::class,
            'Swap' => Abi\Contracts\Swap::class,
            'Token' => Abi\Contracts\Token::class,
        ];

        foreach ($contracts as $contract => $abiClass) {

            $abi = new $abiClass();
            $methods = $abi->getMethods();

            foreach ($methods as $method) {
                $methodFingerprint = $abi->getMethodFingerprint($method);

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

    /**
     * getDataFingerprint
     * Get the 8 digit fingerprint of from the data provided
     */
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
		// if (is_numeric($value)) {
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
        if (! str_starts_with($value, 'z')) {
            return false;
        }

        if (strlen($value) !== 40) {
            return false;
        }

        return true;
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
     */
    public static function sha3(string $value, bool $addPrefix = false): ?string
    {
        if (str_starts_with($value, '0x')) {
            $value = self::hexToBin($value);
        }

        $hash = hash('sha3-256' , $value);

        if ($hash === 'a7ffc6f8bf1ed76651c14756a061d662f580ff4de43b49fa82d80a4b80f8434a') {
            return null;
        }

        if ($addPrefix) {
            return '0x' . $hash;
        }

        return $hash;
    }

    /**
     * toString
     */
    public static function toString(mixed $value): string
    {
        return (string) $value;
    }

    /**
     * toBn
     * Change number or number string to bignumber.
     */
    public static function toBn(mixed $number): array|BigNumber
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
                    strlen($fraction),
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

    /**
     * toBytesArray
     */
    public static function toBytesArray(string $string): array
    {
        $bytes = pack('H*', $string);
        return array_map('ord', str_split($bytes));
    }
}
