<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Ledger extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return a list of all ZTS tokens.
     *
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function getFrontierAccountBlock(string $address): array
    {
        $this->makeRequest('ledger.getFrontierAccountBlock', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of all account blocks sent to this address that have not been included into a momentum so far.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getUnconfirmedBlocksByAddress(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('ledger.getUnconfirmedBlocksByAddress', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of all account blocks sent to this address that currently don't have a corresponding receive account block
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getUnreceivedBlocksByAddress(string $address, int $page = 0, int $perPage = 5): array
    {
        $this->makeRequest('ledger.getUnreceivedBlocksByAddress', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the account block with the specified hash.
     *
     * @param string $hash
     * @return array
     * @throws Exception
     */
    public function getAccountBlockByHash(string $hash): array
    {
        $this->makeRequest('ledger.getAccountBlockByHash', [$hash])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of account blocks for the account-chain with the specified address.
     *
     * @param string $address
     * @param int $height
     * @param int $count
     * @return array
     * @throws Exception
     */
    public function getAccountBlocksByHeight(string $address, int $height =  25, int $count = 5): array
    {
        $this->makeRequest('ledger.getAccountBlocksByHeight', [$address, $height, $count])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of account blocks for the account-chain with the specified address for a specified range of pages.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getAccountBlocksByPage(string $address, int $page =  0, int $perPage = 5): array
    {
        $this->makeRequest('ledger.getAccountBlocksByPage', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the latest momentum.
     *
     * @return array
     * @throws Exception
     */
    public function getFrontierMomentum(): array
    {
        $this->makeRequest('ledger.getFrontierMomentum', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the momentum for the period before the specified time.
     *
     * @param int $time
     * @return array
     * @throws Exception
     */
    public function getMomentumBeforeTime(int $time): array
    {
        $this->makeRequest('ledger.getMomentumBeforeTime', [$time])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return momentums by page.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getMomentumsByPage(int $page =  0, int $perPage = 5): array
    {
        $this->makeRequest('ledger.getMomentumsByPage', [$page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the momentum with the specified hash.
     *
     * @param string $hash
     * @return array
     * @throws Exception
     */
    public function getMomentumByHash(string $hash): array
    {
        $this->makeRequest('ledger.getMomentumByHash', [$hash])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of momentums from height to height + count.
     *
     * @param int $height
     * @param int $count
     * @return array
     * @throws Exception
     */
    public function getMomentumsByHeight(int $height = 1, int $count = 100): array
    {
        $this->makeRequest('ledger.getMomentumsByHeight', [$height, $count])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return a list of momentums from height to height + count with information about the account blocks they contain.
     *
     * @param int $height
     * @param int $count
     * @return array
     * @throws Exception
     */
    public function getDetailedMomentumsByHeight(int $height = 1, int $count = 100): array
    {
        $this->makeRequest('ledger.getDetailedMomentumsByHeight', [$height, $count])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the account-chain of the specified address.
     *
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function getAccountInfoByAddress(string $address): array
    {
        $this->makeRequest('ledger.getAccountInfoByAddress', [$address])
            ->processResponse();

        return $this->result;
    }
}
