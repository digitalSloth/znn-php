<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use DigitalSloth\ZnnPhp\Utilities;

class Encryptor
{
    public function __construct(
        protected readonly string $key,
        protected readonly string $cipher
    ) {}

    public static function setKey(string $key, string $cipher = 'aes-256-gcm'): Encryptor
    {
        return new Encryptor($key, $cipher);
    }

    public function encrypt(string $value)
    {
        // sodium_crypto_aead_aes256gcm_encrypt()

//        // encrypt returns base64-encoded ciphertext
//
//        // The `iv` for a given key must be globally unique to prevent
//        // against forgery attacks. `randomBytes` is convenient for
//        // demonstration but a poor way to achieve this in practice.
//        //
//        // See: e.g. https://csrc.nist.gov/publications/detail/sp/800-38d/final
//        const nonce = new Buffer.from(crypto.randomBytes(12), 'utf8');
//        const cipher = crypto.createCipheriv(ALGO, key, nonce);
//        cipher.setAAD(new Buffer.from("zenon", 'utf8'))
//
//        // Hint: Larger inputs (it's GCM, after all!) should use the stream API
//        let enc = cipher.update(str, 'utf8', 'hex');
//        enc += cipher.final('hex');
//        enc += cipher.getAuthTag().toString('hex')
//        return [enc, nonce];

    }

    public function decrypt(string $encrypted, string $iv, string $authTag)
    {
        $decrypted = openssl_decrypt(
            $encrypted,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $authTag,
            'zenon',
        );

        dd($decrypted);

//        // decrypt decodes base64-encoded ciphertext into a utf8-encoded string
//
//        const decipher = crypto.createDecipheriv(ALGO, key, iv);
//        decipher.setAAD(new Buffer.from("zenon", 'utf8'))
//        decipher.setAuthTag(authTag);
//
//        let str = decipher.update(enc, undefined, 'hex');
//        str += decipher.final('hex');
//        return new Buffer.from(str, 'hex');

    }
}
