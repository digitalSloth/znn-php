<?php

namespace DigitalSloth\ZnnPhp\Test\Unit\Wallet;

use DigitalSloth\ZnnPhp\Test\TestCase;
use DigitalSloth\ZnnPhp\Wallet\KeyPair;

class KeyPairTest extends TestCase
{
    public function testGetAddressFromPrivateKey(): void
    {
        $privateKey = 'f58cb2e1add0382c2004fa8e04895a65a3c755553e60187d697c2e5ab9df67ea';
        $keyPair = KeyPair::fromPrivateKey($privateKey);

        $this->assertEquals('z1qq9n7fpaqd8lpcljandzmx4xtku9w4ftwyg0mq', $keyPair->address->toString());
    }

    public function testGetPublicKeyFromPrivateKey(): void
    {
        $privateKey = 'f58cb2e1add0382c2004fa8e04895a65a3c755553e60187d697c2e5ab9df67ea';
        $keyPair = KeyPair::fromPrivateKey($privateKey);

        $this->assertEquals('881967d6529347a07f73ee2c5f0596b1b4bce44b828ac0a1fd77a0c3f1903559', $keyPair->publicKey);
    }
}
