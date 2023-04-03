<?php

namespace DigitalSloth\ZnnPhp\Formatters;

class BooleanFormatter implements FormatterInterface
{
    public static function format(mixed $value): bool
    {
        return (bool) $value;
    }
}
