<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use Elliptic\EdDSA;
use FurqanSiddiqui\BIP39\BIP39;

class KeyStore
{
    public string $entropy;
    public string $seed;
    protected string $baseAddress;

    public function __construct(
        public string $mnemonic
    ) {

        $mnemonicGenerator = BIP39::Words($this->mnemonic);

        $this->entropy = $mnemonicGenerator->entropy;
        $this->seed = $mnemonicGenerator->generateSeed($this->mnemonic);
    }


    public static function fromMnemonic(string $mnemonic): KeyStore
    {
        return new KeyStore($mnemonic);
    }

    public static function fromEntropy(string $entropy): KeyStore
    {
        $mnemonicGenerator = BIP39::Entropy($entropy);
        $mnemonic = $mnemonicGenerator->words;

        return new KeyStore(implode(' ', $mnemonic));
    }

    public static function random(): KeyStore
    {
        return self::fromEntropy(random_bytes(32));
    }


    public function getKeyPair(int $index = 0)
    {
        $ec = new EdDSA('ed25519');
    }
}
