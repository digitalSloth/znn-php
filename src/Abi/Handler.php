<?php

namespace DigitalSloth\ZnnPhp\Abi;

use DigitalSloth\ZnnPhp\Utilities;
use InvalidArgumentException;

class Handler
{
    public function __construct(
        protected array $types
    )
    {}

    public function encodeParameter(string $type, mixed $param): string
    {
        return $this->encodeParameters([$type], [$param]);
    }

    public function encodeParameters(array $types, array $params): string
    {
        if (count($types) !== count($params)) {
            throw new InvalidArgumentException('encodeParameters number of types must equal to number of params.');
        }

        $abiTypes = $this->parseAbiTypes($types);
        return '0x' . $this->types['tuple']->encode($params, ['coders' => $abiTypes]);
    }

    public function decodeParameter(string $type, mixed $param): string
    {
        return $this->decodeParameters([$type], $param)[0];
    }

    public function decodeParameters(array $types, string $param): array
    {
        $typesLength = count($types);
        $abiTypes = $this->parseAbiTypes($types);

        $results = [];
        $decodeResults = $this->types['tuple']->decode(Utilities::stripZero($param), 0, ['coders' => $abiTypes]);
        for ($i = 0; $i < $typesLength; $i++) {
            if (empty($outputTypes['outputs'][$i]['name']) === false) {
                $results[$outputTypes['outputs'][$i]['name']] = $decodeResults[$i];
            } else {
                $results[$i] = $decodeResults[$i];
            }
        }
        return $results;
    }


    public function nestedTypes(string $name): mixed
    {
        $matches = [];

        if (preg_match_all('/(\[[0-9]*\])/', $name, $matches, PREG_PATTERN_ORDER) >= 1) {
            return $matches[0];
        }

        return false;
    }

    public function nestedName(string $name): string
    {
        $nestedTypes = $this->nestedTypes($name);

        if ($nestedTypes === false) {
            return $name;
        }

        return mb_substr($name, 0, mb_strlen($name) - mb_strlen($nestedTypes[count($nestedTypes) - 1]));
    }

    public function isDynamicArray(string $name): bool
    {
        return preg_match('/\[\]$/', $name) >= 1;
    }

    public function isStaticArray(string $name): bool
    {
        return preg_match('/\[[\d]+\]$/', $name) >= 1;
    }

    public function isTuple(string $name): bool
    {
        return preg_match('/^(tuple)?\((.*)\)$/', $name) >= 1;
    }


    protected function parseTupleTypes(string $type, bool $parseInner = false): array
    {
        $leftBrackets = [];
        $results = [];
        $offset = 0;

        for ($key = 0, $keyMax = mb_strlen($type); $key < $keyMax; $key++) {
            $char = $type[$key];
            if ($char === '(') {
                $leftBrackets[] = $key;
            } else if ($char === ')') {
                $leftKey = array_pop($leftBrackets);
                if (is_null($leftKey)) {
                    throw new InvalidArgumentException('Wrong tuple type: ' . $type);
                }
            } else if (($char === ',') && empty($leftBrackets)) {
                $length = $key - $offset;
                $results[] = mb_substr($type, $offset, $length);
                $offset += $length + 1;
            }
        }

        if ($offset < mb_strlen($type)) {
            $results[] = mb_substr($type, $offset);
        }

        if ($parseInner && count($results) === 1 && $results[0] === $type && $type[0] === '(' && $type[mb_strlen($type) - 1] === ')') {
            $results[0] = mb_substr($type, 1, -1);
        }

        return $results;
    }

    protected function findAbiType(string $type): array
    {
        $solidityType = $this->getSolidityType($type);

        if ($this->isDynamicArray($type)) {
            $nestedType = $this->nestedName($type);

            return [
                'type' => $type,
                'dynamic' => true,
                'solidityType' => $solidityType,
                'coders' => $this->findAbiType($nestedType)
            ];
        }

        if ($this->isStaticArray($type)) {
            $nestedType = $this->nestedName($type);

            $result = [
                'type' => $type,
                'dynamic' => false,
                'solidityType' => $solidityType,
                'coders' => $this->findAbiType($nestedType)
            ];
            if ($result['coders']['dynamic']) {
                $result['dynamic'] = true;
            }
            return $result;
        }

        if ($this->isTuple($type)) {
            $nestedType = $this->parseTupleTypes($type, true)[0];
            $parsedNestedTypes = $this->parseTupleTypes($nestedType);

            $tupleAbi = [
                'type' => $type,
                'dynamic' => false,
                'solidityType' => $solidityType,
                'coders' => []
            ];

            foreach ($parsedNestedTypes as $type_) {
                $parsedType = $this->findAbiType($type_);
                if ($parsedType['dynamic']) {
                    $tupleAbi['dynamic'] = true;
                }
                $tupleAbi['coders'][] = $parsedType;
            }

            return $tupleAbi;
        }

        return [
            'type' => $type,
            'solidityType' => $solidityType,
            'dynamic' => $solidityType->isDynamicType()
        ];
    }

    protected function getSolidityType(string $type): AbiType
    {
        $match = [];

        if ($this->isDynamicArray($type)) {
            return $this->types['dynamicArray'];
        }

        if ($this->isStaticArray($type)) {
            return $this->types['sizedArray'];
        }

        if ($this->isTuple($type)) {
            return $this->types['tuple'];
        }

        if (preg_match('/^([a-zA-Z]+)/', $type, $match) === 1) {
            $className = $this->types[$match[0]] ?? null;
            if (isset($className)) {
                // check dynamic bytes
                if ($match[0] === 'bytes' && ($className->isType($type) === false)) {
                    $className = $this->types['dynamicBytes'];
                }
                return $className;
            }
        }

        throw new InvalidArgumentException('Unsupport solidity parameter type: ' . $type);
    }

    protected function parseAbiTypes(array $types): array
    {
        $result = [];

        foreach ($types as $type) {
            $result[] = $this->findAbiType($type);
        }

        return $result;
    }
}
