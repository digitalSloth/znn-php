<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Htlc extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function GetById(string $id): array
    {
        $this->makeRequest('embedded.htlc.getById', [$id])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function GetProxyUnlockStatus(string $address): array
    {
        $this->makeRequest('embedded.htlc.getProxyUnlockStatus', [$address])
            ->processResponse();

        return $this->result;
    }
}
