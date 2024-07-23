<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Wallet;

use DigitalSloth\ZnnPhp\Test\TestCase;
use DigitalSloth\ZnnPhp\Wallet\KeyStore;

class KeyStoreTest extends TestCase
{
    public function testCreateKeyStoreFrom24Mnemonic(): void
    {
        $mnemonic = "abstract affair idle position alien fluid board ordinary exist afraid chapter wood wood guide sun walnut crew perfect place firm poverty model side million";
        $keyStore = KeyStore::fromMnemonic($mnemonic);

        $this->assertEquals('z1qq9n7fpaqd8lpcljandzmx4xtku9w4ftwyg0mq', $keyStore->baseAddress->toString());
        $this->assertEquals('00e089c2d43064b3462ce24fc09099fe9fd2cf3657b6335462972baa911d31fc', $keyStore->entropy->toString());
    }

    public function testCreateKeyStoreFrom24EntropyMnemonic(): void
    {
        $entropy = "00e089c2d43064b3462ce24fc09099fe9fd2cf3657b6335462972baa911d31fc";
        $keyStore = KeyStore::fromEntropy($entropy);

        $this->assertEquals('z1qq9n7fpaqd8lpcljandzmx4xtku9w4ftwyg0mq', $keyStore->baseAddress->toString());
        $this->assertEquals('abstract affair idle position alien fluid board ordinary exist afraid chapter wood wood guide sun walnut crew perfect place firm poverty model side million', $keyStore->mnemonic);
    }

//    public function testCreateKeyStoreFrom12Mnemonic(): void
//    {
//        $mnemonic = "room learn castle divide disorder delay empty release mercy moon beauty solar";
//        $keyStore = KeyStore::fromMnemonic($mnemonic);
//
//        $this->assertEquals('z1qrf825tea0hha086vjnn4dhpl5wsdcesktxh5x', $keyStore->baseAddress->toString());
//        $this->assertEquals('bbefd88e1ff3f673d24da98b51f04ee7', $keyStore->entropy->toString());
//    }

//    public function testCreateKeyStoreFrom12EntropyMnemonic(): void
//    {
//        $entropy = "bbefd88e1ff3f673d24da98b51f04ee7";
//        $keyStore = KeyStore::fromEntropy($entropy);
//
//        $this->assertEquals('z1qrf825tea0hha086vjnn4dhpl5wsdcesktxh5x', $keyStore->baseAddress->toString());
//        $this->assertEquals('room learn castle divide disorder delay empty release mercy moon beauty solar', $keyStore->mnemonic);
//    }
}
