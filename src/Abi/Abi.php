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
use DigitalSloth\ZnnPhp\Exceptions\DecodeException;
use DigitalSloth\ZnnPhp\Exceptions\EncodeException;
use DigitalSloth\ZnnPhp\Utilities;

class Abi
{
    protected array $abi = [];

    protected Handler $handler;

    public function __construct()
    {
        $this->handler = new Handler([
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

    public function checkMethodName($methodName): string
    {
        foreach ($this->abi as $abi) {
            if ($abi['name'] === $methodName) {
                return true;
            }
        }

        return false;
    }

    public function getMethodSignature($methodName): string
    {
        if ($this->checkMethodName($methodName)) {
            $inputs = $this->getParameterTypes($methodName);
            return utf8_encode("{$methodName}($inputs)");
        }

        return utf8_encode("{$methodName}()");
    }

    public function getSignatureFingerprint($methodName): string
    {
        $signature = $this->getMethodSignature($methodName);
        $hash = hash('sha3-256', $signature);

        return substr($hash, 0, 8);
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







    public function decode($methodName, $data): array
    {
        // Strip signature from data
        $data = substr(Utilities::toHex($data), 8);

        $types = $this->getParameterTypes($methodName);
        $types = explode(',', $types);

        if (! empty($data)) {
            try {
                return $this->handler->decodeParameters($types, $data);
            } catch (\Exception $ex) {
                throw new DecodeException($ex->getMessage());
            }
        }
    }

    public function encode($methodName, $data): string
    {
        $signature = $this->getSignatureFingerprint($methodName);

        $types = $this->getParameterTypes($methodName);
        $types = explode(',', $types);

        if (! empty($data)) {
            try {

                $output = $this->handler->encodeParameters($types, $data);
                $output = $signature . Utilities::stripZero($output);

                return Utilities::hexToBin($output);
            } catch (\Exception $ex) {
                throw new EncodeException($ex->getMessage());
            }
        }
    }
}
