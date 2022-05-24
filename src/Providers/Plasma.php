<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Plasma extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return plasma information about an address.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function get(string $address): array
    {
        $this->makeRequest('embedded.plasma.get', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the list of all plasma fusion entries.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getEntriesByAddress(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.plasma.getEntriesByAddress', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return plasma information the specified address for a specified range of pages.
     *
     * @param string $address
     * @param int $blockType
     * @param string $toAddress
     * @param string $data
     * @return array
     * @throws ApiException|HttpException
     */
    public function getRequiredPoWForAccountBlock(string $address, int $blockType, string $toAddress, string $data): array
    {
        $this->makeRequest('embedded.plasma.getEntriesByAddress', [$address, $blockType, $toAddress, $data])
            ->processResponse();

        return $this->result;
    }
}
