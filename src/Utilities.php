<?php

namespace DigitalSloth\ZnnPhp;

use BitWasp\Bech32;
use BitWasp\Bech32\Exception\Bech32Exception;
use Elliptic\EdDSA;

class Utilities
{
    public static function addressFromPublicKey(string $publicKey): bool|string
    {
        $hrp = 'z';
        $hash = hash('sha3-256', hex2bin($publicKey), true);
        $binary = [0];

        // Convert hash to bytes array
        for ($i = 0; $i < strlen($hash); $i++) {
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

    public static function encodeData($data): ?string
    {
        if ($data) {
            $data = hex2bin($data);
            return base64_encode($data);
        }

        return null;
    }

    public static function decodeData($data): ?string
    {
        if ($data) {
            $data = base64_decode($data);
            return bin2hex($data);
        }

        return null;
    }

    public static function guessAbiMethod(string $data): ?array
    {
        $fingerprint = substr(self::decodeData($data), 0, 8);

        $contracts = [
            'Accelerator' => \DigitalSloth\ZnnPhp\Abi\Accelerator::class,
            'Common' => \DigitalSloth\ZnnPhp\Abi\Common::class,
            'Pillar' => \DigitalSloth\ZnnPhp\Abi\Pillar::class,
            'Plasma' => \DigitalSloth\ZnnPhp\Abi\Plasma::class,
            'Sentinel' => \DigitalSloth\ZnnPhp\Abi\Sentinel::class,
            'Stake' => \DigitalSloth\ZnnPhp\Abi\Stake::class,
            'Token' => \DigitalSloth\ZnnPhp\Abi\Token::class,
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
        return substr(static::decodeData($data), 0, 8);
    }
}
