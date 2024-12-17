<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use ParagonIE\Sodium\Compat;

class KeyDerivation
{
    private const ED25519_CURVE = 'ed25519 seed';
    private const HARDENED_OFFSET = 0x80000000;

    private string $path;
    private string $seed;
    private int $offset;

    public function __construct(string $path, string $seed, int $offset = self::HARDENED_OFFSET)
    {
        if (! $this->isValidPath($path)) {
            throw new \InvalidArgumentException('Invalid derivation path');
        }

        $this->path = $path;
        $this->seed = $seed;
        $this->offset = $offset;
    }

    public static function derivePath(string $path, string $seed): array
    {
        return (new self($path, $seed))->makeKeys();
    }

    private function makeKeys(): array
    {
        $keys = $this->getMasterKeyFromSeed($this->seed);
        $segments = explode('/', $this->path);
        array_shift($segments);

        foreach ($segments as $segment) {
            $index = intval(rtrim($segment, "'")) + $this->offset;
            $keys = $this->CKDPriv($keys, $index);
        }

        return $keys;
    }

    private function isValidPath(string $path): bool
    {
        // Define the regex pattern to match paths like "m/44'/73404'/0'"
        $pathRegex = "/^m(\\/[0-9]+')+$/";

        if (!preg_match($pathRegex, $path)) {
            return false;
        }

        // Split the path and check each segment after "m/"
        $segments = explode('/', $path);
        foreach (array_slice($segments, 1) as $segment) {
            // Use replaceDerive logic from JS: remove the "'" and check if numeric
            $strippedSegment = str_replace("'", '', $segment);
            if (!is_numeric($strippedSegment)) {
                return false;
            }
        }

        return true;
    }

    private function getMasterKeyFromSeed(string $seed): array
    {
        $hmac = hash_hmac('sha512', hex2bin($seed), self::ED25519_CURVE, true);
        $IL = substr($hmac, 0, 32);
        $IR = substr($hmac, 32);
        return ['key' => $IL, 'chainCode' => $IR];
    }

    private function CKDPriv(array $keys, int $index): array
    {
        $indexBytes = pack('N', $index);
        $data = chr(0) . $keys['key'] . $indexBytes;
        $I = hash_hmac('sha512', $data, $keys['chainCode'], true);
        $IL = substr($I, 0, 32);
        $IR = substr($I, 32);
        return ['key' => $IL, 'chainCode' => $IR];
    }

    private function getPublicKey(string $privateKey, bool $withZeroByte = true): string
    {
        $keyPair = Compat::crypto_sign_seed_keypair($privateKey);
        $publicKey = substr($keyPair, 32, 32);
        return $withZeroByte ? chr(0) . $publicKey : $publicKey;
    }
}
