<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use DigitalSloth\ZnnPhp\Model\Primitives\Address;
use DigitalSloth\ZnnPhp\Utilities;
use Elliptic\EdDSA;
use FurqanSiddiqui\BIP39\BIP39;

class KeyStore
{
    public string $entropy;
    public string $seed;
    public Address $baseAddress;

    public function __construct(
        public string $mnemonic
    ) {
        $mnemonicGenerator = BIP39::Words($this->mnemonic);
        $this->entropy = $mnemonicGenerator->entropy;
        $this->seed = Utilities::toHex(BIP39::Entropy($this->entropy)->generateSeed());
        $this->baseAddress = $this->getKeyPair()->address;
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
        $random = Utilities::toHex(random_bytes(32));
        return self::fromEntropy($random);
    }

    public function getKeyPair(int $index = 0): KeyPair
    {
        $derivationPath = "m/44'/73404'/{$index}'";
        $derivation = KeyDerivation::derivePath($derivationPath, $this->seed);
        $key = Utilities::toHex($derivation['key']);

        return KeyPair::fromPrivateKey($key);
    }
}
