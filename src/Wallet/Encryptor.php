<?php

namespace DigitalSloth\ZnnPhp\Wallet;

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
        // TODO - adapt the following js

//        const nonce = new Buffer.from(crypto.randomBytes(12), 'utf8');
//        const cipher = crypto.createCipheriv(ALGO, key, nonce);
//        cipher.setAAD(new Buffer.from("zenon", 'utf8'))
//
//        let enc = cipher.update(str, 'utf8', 'hex');
//        enc += cipher.final('hex');
//        enc += cipher.getAuthTag().toString('hex')
//        return [enc, nonce];
    }

    public function decrypt(string $data, string $iv, string $authTag)
    {
        // TODO - adapt the following js

//        data = Buffer.from(encrypted.substr(0, encrypted.length - 32), 'hex'),
//        iv = Buffer.from(aesNonce, 'hex'),
//        authTag = Buffer.from(encrypted.substr(encrypted.length - 32, 32), 'hex'),
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
