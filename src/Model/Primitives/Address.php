<?php

namespace DigitalSloth\ZnnPhp\Model\Primitives;

use function BitWasp\Bech32\encode;
use function BitWasp\Bech32\decode;

class Address
{
    public function __construct(
        public array $core
    ) {}

    public static function parse(string $address)
    {
        $decoded = decode($address);
        return new Address($decoded[1]);
    }

    public function toString()
    {
        return encode('z', $this->core);
    }
}
