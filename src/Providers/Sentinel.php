<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Sentinel extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return all the Sentinels registered by an address.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getByOwner(string $address): array
    {
        $this->makeRequest('embedded.sentinel.getByOwner', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of all registered Sentinels.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAllActive(int $page = 0, int $perPage = 1000): array
    {
        $this->makeRequest('embedded.sentinel.getAllActive', [$page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the amount of QSR the address has deposited in order to create a Sentinel.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getDepositedQsr(string $address): array
    {
        $this->makeRequest('embedded.sentinel.getDepositedQsr', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the uncollected reward for the specified sentinel.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getUncollectedReward(string $address): array
    {
        $this->makeRequest('embedded.sentinel.getUncollectedReward', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return reward information the specified sentinel for a specified range of pages.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getFrontierRewardByPage(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.sentinel.getFrontierRewardByPage', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }
}
