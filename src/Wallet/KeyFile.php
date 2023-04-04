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

    public static function encrypt(KeyStore $store, string $password): array
    {
        $baseAddress = $store->baseAddress->toString();
        $salt = random_bytes(16);
        $time = 1;
        $memory = 64 * 1024;
        $parallelism = 4;
        $hashLength = 32;

        // TODO - returned key doesnt match expected result
        // @see https://github.com/alien-valley/znn.js/blob/master/src/wallet/keyFile.spec.js
        // Expected results:
        // $baseAddress = 'z1qq9n7fpaqd8lpcljandzmx4xtku9w4ftwyg0mq';
        // $key = 'e85a18546e4a45a09ab1312171b026fd2edd2d7957cae2360264f7425cef71d2';
        $command = 'echo '.$password.' | argon2 '.$salt.' -id -l '.$hashLength.' -t '.$time.' -p '.$parallelism.' -k '.$memory .' -r';
        $key = exec($command);

        [$encrypted, $aesNonce] = Encryptor::setKey($key)->encrypt($store->entropy);

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
        $salt = Utilities::stripZero($json->crypto->argon2Params->salt);
        $encrypted = Utilities::stripZero($json->crypto->cipherData);
        $aesNonce = Utilities::stripZero($json->crypto->nonce);

        $time = 1;
        $memory = 64 * 1024;
        $parallelism = 4;
        $hashLength = 32;

        // TODO - returned key doesnt match expected result
        // @see https://github.com/alien-valley/znn.js/blob/master/src/wallet/keyFile.spec.js
        // Expected results:
        // $key = 'e85a18546e4a45a09ab1312171b026fd2edd2d7957cae2360264f7425cef71d2';
        $command = 'echo '.$password.' | argon2 '.$salt.' -id -l '.$hashLength.' -t '.$time.' -p '.$parallelism.' -k '.$memory .' -r';
        $key = exec($command);
        $key = str_replace(["\r", "\n"], '', $key);

        $data = substr($encrypted, 0, strlen($encrypted) - 32);
        $authTag = substr($encrypted, strlen($encrypted) - 32, 32);

        return Encryptor::setKey($key)->decrypt(
            $data,
            $aesNonce,
            $authTag
        );
    }
}
