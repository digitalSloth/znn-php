<?php

namespace DigitalSloth\ZnnPhp\Model\Primitives;

use DigitalSloth\ZnnPhp\Utilities;
use function BitWasp\Bech32\convertBits;
use function BitWasp\Bech32\encode;

class Address
{
    public function __construct(
        protected array $core
    ) {

    }

    public static function parse(string $address)
    {
        $bytes = Utilities::toBytesArray($address);
        $digest = array_slice($bytes, 0, 20);
        $bech32 = convertBits($digest, count($digest), 8, 5);

        return new Address($bech32);
    }

    public function toString()
    {
        return encode('z', $this->core);
    }
}
