<?php

namespace DigitalSloth\ZnnPhp\Model\Primitives;

use function BitWasp\Bech32\decode;
use function BitWasp\Bech32\encode;

class TokenStandard
{
    public function __construct(
        public array $core
    ) {}

    public static function parse(string $zts): TokenStandard
    {
        $decoded = decode($zts);
        return new TokenStandard($decoded[1]);
    }

    public function toString(): string
    {
        return encode('zts', $this->core);
    }
}
