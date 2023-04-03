<?php

namespace DigitalSloth\ZnnPhp\Model\Primitives;

use DigitalSloth\ZnnPhp\Utilities;

class Hash
{
    public function __construct(
        public array $core
    ) {}

    public static function parse(string $hash)
    {
        $bytes = Utilities::toBytesArray($hash);
        return new Hash($bytes);
    }

    public static function digest($data)
    {
        $hash = Utilities::sha3($data);
        $data = Utilities::toBytesArray($hash);
        return new Hash($data);
    }

    public function toString()
    {
        $value = array_map('chr', $this->core);
        $value = implode($value);
        return Utilities::toHex($value);
    }
}
