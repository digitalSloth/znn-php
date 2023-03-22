<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use Elliptic\EdDSA;

class KeyPair
{
    public string $publicKey;
    public string $address;

    public function __construct(
        protected string $privateKey
    ) {
        $ec = new EdDSA('ed25519');
        $this->publicKey = $ec->keyFromSecret($this->privateKey)->getPublic('hex');
    }


    public static function fromPrivateKey(string $privateKey): KeyPair
    {
        return new KeyPair($privateKey);
    }

    public function sign($data)
    {

    }
}
