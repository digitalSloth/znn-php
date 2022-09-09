<?php

namespace DigitalSloth\ZnnPhp\Abi;

use DigitalSloth\ZnnPhp\Abi\Types\Address;
use DigitalSloth\ZnnPhp\Abi\Types\Boolean;
use DigitalSloth\ZnnPhp\Abi\Types\Bytes;
use DigitalSloth\ZnnPhp\Abi\Types\DynamicBytes;
use DigitalSloth\ZnnPhp\Abi\Types\Hash;
use DigitalSloth\ZnnPhp\Abi\Types\Integer;
use DigitalSloth\ZnnPhp\Abi\Types\Str;
use DigitalSloth\ZnnPhp\Abi\Types\TokenStandard;
use DigitalSloth\ZnnPhp\Abi\Types\Uinteger;
use DigitalSloth\ZnnPhp\Utilities;
use Web3\Contracts\Ethabi;
use function BitWasp\Bech32\convertBits;
use function BitWasp\Bech32\encode;

class Abi
{
    protected array $abi = [];

    protected Ethabi $ethAbi;

    protected int $encodedSignLength = 4;

    public function __construct()
    {
        $this->ethAbi = new Ethabi([
            'address' => new Address,
            'bool' => new Boolean,
            'bytes' => new Bytes,
            'dynamicBytes' => new DynamicBytes,
            'hash' => new Hash,
            'int' => new Integer,
            'string' => new Str,
            'tokenStandard' => new TokenStandard,
            'uint' => new Uinteger,
        ]);
    }

    public function getMethods(): array
    {
        $methods = [];

        foreach ($this->abi as $abi) {
            if ($abi['type'] === 'function') {
                $methods[] = $abi['name'];
            }
        }

        return $methods;
    }

    public function getMethodSignature($methodName): string
    {
        if ($this->checkMethodName($methodName)) {
            $inputs = $this->getParameterTypes($methodName);
            return utf8_encode("{$methodName}($inputs)");
        }

        return utf8_encode("{$methodName}()");
    }

    public function checkMethodName($methodName): string
    {
        foreach ($this->abi as $abi) {
            if ($abi['name'] === $methodName) {
                return true;
            }
        }

        return false;
    }

    public function getParameterTypes($methodName): string
    {
        $inputs = [];

        foreach ($this->abi as $abi) {
            if ($abi['name'] === $methodName) {
                foreach ($abi['inputs'] as $input) {
                    $inputs[] = $input['type'];
                }

                break;
            }
        }

        return implode(',', $inputs);
    }

    public function getParameterNames($methodName): string
    {
        $inputs = [];

        foreach ($this->abi as $abi) {
            if ($abi['name'] === $methodName) {
                foreach ($abi['inputs'] as $input) {
                    $inputs[] = $input['name'];
                }

                break;
            }
        }

        return implode(',', $inputs);
    }

    public function getSignatureFingerprint($methodName): string
    {
        $signature = $this->getMethodSignature($methodName);
        $hash = hash('sha3-256', $signature);

        return substr($hash, 0, 8);
    }

    public function decode($methodName, $data): array
    {
        $output = [];

        // Strip signature from data
        $data = substr(Utilities::decodeData($data), 8);

        $types = $this->getParameterTypes($methodName);
        $types = explode(',', $types);

        $names = $this->getParameterNames($methodName);
        $names = explode(',', $names);

        if (! empty($data)) {
            try {
                $decoded = $this->ethAbi->decodeParameters($types, $data);
            } catch (\Exception $ex) {
                $decoded =  [];
            }

            $i = 0;
            foreach ($decoded as $value) {
                $output[$names[$i]] = $this->parseValue($value, $types[$i]);
                $i++;
            }
        }

        return $output;
    }

    public function parseValue($value, $type)
    {
        if ($type === 'string' || $type === 'hash') {
            return (string) $value;
        }

        if ($type === 'tokenStandard') {

            $address = substr($value, 2);
            $bytes = pack('H*', $address);
            $bytes = array_map('ord', str_split($bytes));

            // Get last 10 array elements
            $digest = array_slice($bytes, 10, 10);
            $bech32  = convertBits($digest, count($digest), 8, 5);

            return encode('zts', $bech32);
        }

        if ($type === 'address') {

            $address = substr($value, 2);
            $bytes = pack('H*', $address);
            $bytes = array_map('ord', str_split($bytes));

            // Get first 20 array elements
            $digest = array_slice($bytes, 0, 20);
            $bech32  = convertBits($digest, count($digest), 8, 5);

            return encode('z', $bech32);
        }

        if ($type === 'uint8' || $type === 'uint256' || $type === 'int64') {
            return (string) $value;
        }

        return $value;
    }
}
