<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

interface TypeInterface
{
    /**
     * isType
     *
     * @param string $name
     * @return bool
     */
    public function isType(string $name): bool;

    /**
     * isDynamicType
     *
     * @return bool
     */
    public function isDynamicType(): bool;

    /**
     * inputFormat
     *
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function inputFormat(mixed $value, string $name): string;
}
