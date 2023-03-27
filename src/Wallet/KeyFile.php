<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use DigitalSloth\ZnnPhp\Utilities;
use Elliptic\EdDSA;

class KeyFile
{
    public string $publicKey;
    public string $address;

    public function __construct(
        protected string $privateKey
    ) {
        $ec = new EdDSA('ed25519');
        $this->publicKey = $ec->keyFromSecret($this->privateKey)->getPublic('hex');
    }

    public static function encrypt(string $store, string $password): array
    {
        $baseAddress = 'z1qrq4h28kd6u47e8mrf5juqwfff3sdgvw7xfrfc';
        $salt = random_bytes(16);

        $key = bin2hex(sodium_crypto_pwhash(
            32,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        ));

        [$encrypted, $aesNonce] = Encryptor::setKey('key.hash')->encrypt('Buffer.from(store.entropy, "hex")');

        return [
            'baseAddress' => $baseAddress,
            'crypto' => [
                'argon2Params' => [
                    'salt' => '0x' . bin2hex($salt),
                ],
                'cipherData' => "0x{$encrypted}",
                'cipherName' => "aes-256-gcm",
                'kdf' => "argon2.IDKey",
                'nonce' => "0x{$aesNonce}",
            ],
            'timestamp' => time(),
            'version' => 1
        ];
    }

    public static function decrypt(string $json, string $password): KeyFile
    {
        $json = json_decode($json);
        $givenBaseAddress = $json->baseAddress;
        $salt = Utilities::stripZero($json->crypto->argon2Params->salt);
        $encrypted = Utilities::stripZero($json->crypto->cipherData);
        $aesNonce = Utilities::stripZero($json->crypto->nonce);

        $key = bin2hex(sodium_crypto_pwhash(
            32,
            $password,
            hex2bin($salt),
            1,
            64 * 1024,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        ));

//        const aesCipher = aes256gcm(key.hash);
//        const entropy = aesCipher.decrypt(
//                Buffer.from(encrypted.substr(0, encrypted.length - 32), 'hex'),
//                Buffer.from(aesNonce, 'hex'),
//                Buffer.from(encrypted.substr(encrypted.length - 32, 32), 'hex'),
//            ).subarray(0, 32);

        [$encrypted, $aesNonce] = Encryptor::setKey($key)->decrypt(
            pack('H*', substr($encrypted, 0, strlen($encrypted) - 32)),
            pack('H*', $aesNonce),
            pack('H*', substr($encrypted, strlen($encrypted) - 32, 32))
        );

        dd($encrypted, $aesNonce);

    }
}
