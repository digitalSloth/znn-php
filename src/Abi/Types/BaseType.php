<?php

namespace DigitalSloth\ZnnPhp\Abi\Types;

use Web3\Utils;
use Web3\Formatters\IntegerFormatter;

class BaseType
{
    /**
     * construct
     *
     * @return void
     */
    // public function  __construct() {}

    /**
     * get
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], []);
        }
        return false;
    }

    /**
     * set
     *
     * @param string $name
     * @param mixed $value
     * @return mixed;
     */
    public function __set(string $name, mixed $value)
    {
        $method = 'set' . ucfirst($name);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], [$value]);
        }
        return false;
    }

    /**
     * callStatic
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    // public static function __callStatic($name, $arguments) {}

    /**
     * nestedTypes
     *
     * @param string $name
     * @return mixed
     */
    public function nestedTypes(string $name): mixed
    {
        $matches = [];

        if (preg_match_all('/(\[[0-9]*\])/', $name, $matches, PREG_PATTERN_ORDER) >= 1) {
            return $matches[0];
        }
        return false;
    }

    /**
     * nestedName
     *
     * @param string $name
     * @return string
     */
    public function nestedName(string $name): string
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            return $name;
        }
        return mb_substr($name, 0, mb_strlen($name) - mb_strlen($nestedTypes[count($nestedTypes) - 1]));
    }

    /**
     * isDynamicArray
     *
     * @param string $name
     * @return bool
     */
    public function isDynamicArray(string $name): bool
    {
        $nestedTypes = $this->nestedTypes($name);

        return $nestedTypes && preg_match('/[0-9]+/', $nestedTypes[count($nestedTypes) - 1]) !== 1;
    }

    /**
     * isStaticArray
     *
     * @param string $name
     * @return bool
     */
    public function isStaticArray(string $name): bool
    {
        $nestedTypes = $this->nestedTypes($name);

        return $nestedTypes && preg_match('/[0-9]+/', $nestedTypes[count($nestedTypes) - 1]) === 1;
    }

    /**
     * staticArrayLength
     *
     * @param string $name
     * @return int
     */
    public function staticArrayLength(string $name): int
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            return 1;
        }
        $match = [];

        if (preg_match('/[0-9]+/', $nestedTypes[count($nestedTypes) - 1], $match) === 1) {
            return (int) $match[0];
        }
        return 1;
    }

    /**
     * staticPartLength
     *
     * @param string $name
     * @return int
     */
    public function staticPartLength(string $name): int
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            $nestedTypes = ['[1]'];
        }
        $count = 32;

        foreach ($nestedTypes as $type) {
            $num = mb_substr($type, 1, 1);

            if (!is_numeric($num)) {
                $num = 1;
            } else {
                $num = intval($num);
            }
            $count *= $num;
        }

        return $count;
    }

    /**
     * isDynamicType
     *
     * @return bool
     */
    public function isDynamicType(): bool
    {
        return false;
    }

    /**
     * encode
     *
     * @param mixed $value
     * @param string $name
     * @return array|string
     */
    public function encode(mixed $value, string $name): array|string
    {
        if ($this->isDynamicArray($name)) {
            $length = count($value);
            $nestedName = $this->nestedName($name);
            $result = [];
            $result[] = IntegerFormatter::format($length);

            foreach ($value as $val) {
                $result[] = $this->encode($val, $nestedName);
            }
            return $result;
        } elseif ($this->isStaticArray($name)) {
            $length = $this->staticArrayLength($name);
            $nestedName = $this->nestedName($name);
            $result = [];

            foreach ($value as $val) {
                $result[] = $this->encode($val, $nestedName);
            }
            return $result;
        }
        return $this->inputFormat($value, $name);
    }

    /**
     * decode
     *
     * @param mixed $value
     * @param string $offset
     * @param string $name
     * @return mixed
     */
    public function decode(mixed $value, string $offset, string $name): mixed
    {
        if ($this->isDynamicArray($name)) {
            $arrayOffset = (int) Utils::toBn('0x' . mb_substr($value, $offset * 2, 64))->toString();
            $length = (int) Utils::toBn('0x' . mb_substr($value, $arrayOffset * 2, 64))->toString();
            $arrayStart = $arrayOffset + 32;

            $nestedName = $this->nestedName($name);
            $nestedStaticPartLength = $this->staticPartLength($nestedName);
            $roundedNestedStaticPartLength = floor(($nestedStaticPartLength + 31) / 32) * 32;
            $result = [];

            for ($i=0; $i<$length * $roundedNestedStaticPartLength; $i+=$roundedNestedStaticPartLength) {
                $result[] = $this->decode($value, $arrayStart + $i, $nestedName);
            }
            return $result;
        } elseif ($this->isStaticArray($name)) {
            $length = $this->staticArrayLength($name);
            $arrayStart = $offset;

            $nestedName = $this->nestedName($name);
            $nestedStaticPartLength = $this->staticPartLength($nestedName);
            $roundedNestedStaticPartLength = floor(($nestedStaticPartLength + 31) / 32) * 32;
            $result = [];

            for ($i=0; $i<$length * $roundedNestedStaticPartLength; $i+=$roundedNestedStaticPartLength) {
                $result[] = $this->decode($value, $arrayStart + $i, $nestedName);
            }
            return $result;
        } elseif ($this->isDynamicType()) {
            $dynamicOffset = (int) Utils::toBn('0x' . mb_substr($value, $offset * 2, 64))->toString();
            $length = (int) Utils::toBn('0x' . mb_substr($value, $dynamicOffset * 2, 64))->toString();
            $roundedLength = floor(($length + 31) / 32);
            $param = mb_substr($value, $dynamicOffset * 2, ( 1 + $roundedLength) * 64);
            return $this->outputFormat($param, $name);
        }
        $length = $this->staticPartLength($name);
        $param = mb_substr($value, $offset * 2, $length * 2);

        return $this->outputFormat($param, $name);
    }
}
