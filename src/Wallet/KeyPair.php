<?php

namespace DigitalSloth\ZnnPhp\Wallet;

use DigitalSloth\ZnnPhp\Model\Primitives\Address;
use DigitalSloth\ZnnPhp\Utilities;
use Elliptic\EdDSA;
use function BitWasp\Bech32\convertBits;

class KeyPair
{
    public string $publicKey;
    public Address $address;

    public function __construct(
        protected string $privateKey
    ) {
        $ec = new EdDSA('ed25519');
        $this->publicKey = $ec->keyFromSecret($this->privateKey)->getPublic('hex');

        $data = Utilities::sha3(hex2bin($this->publicKey));
        $data = [0, ...Utilities::toBytesArray($data)];
        $digest = array_slice($data, 0, 20);
        $core = convertBits($digest, count($digest), 8, 5);

        $this->address = new Address($core);
    }

    public static function fromPrivateKey(string $privateKey): KeyPair
    {
        return new KeyPair($privateKey);
    }

    public function sign(mixed $data): EdDSA\Signature
    {
        //TODO - needs testing
        $ec = new EdDSA('ed25519');
        return $ec->sign($data->core, $this->privateKey);
    }
}
