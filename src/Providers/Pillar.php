<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Pillar extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return the current QSR cost for registering a new Pillar.
     *
     * @return array
     * @throws ApiException|HttpException
     */
    public function getQsrRegistrationCost(): array
    {
        $this->makeRequest('embedded.pillar.getQsrRegistrationCost', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the availability of a name for a Pillar.
     *
     * @param string $name
     * @return array
     * @throws ApiException|HttpException
     */
    public function checkNameAvailability(string $name): array
    {
        $this->makeRequest('embedded.pillar.checkNameAvailability', [$name])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the list of Pillars in the network with additional information.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAll(int $page = 0, int $perPage = 1000): array
    {
        $this->makeRequest('embedded.pillar.getAll', [$page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return all the Pillars registered by an address.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getByOwner(string $address): array
    {
        $this->makeRequest('embedded.pillar.getByOwner', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the Pillar with the specified name.
     *
     * @param string $name
     * @return array
     * @throws ApiException|HttpException
     */
    public function getByName(string $name): array
    {
        $this->makeRequest('embedded.pillar.getByName', [$name])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the total number of delegations for a particular Pillar.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getDelegatedPillar(string $address): array
    {
        $this->makeRequest('embedded.pillar.getDelegatedPillar', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the amount of QSR deposited that can be used to create a Pillar.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getDepositedQsr(string $address): array
    {
        $this->makeRequest('embedded.pillar.getDepositedQsr', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the uncollected reward for the specified pillar.
     *
     * @param string $address
     * @return array
     * @throws ApiException|HttpException
     */
    public function getUncollectedReward(string $address): array
    {
        $this->makeRequest('embedded.pillar.getUncollectedReward', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return reward information about the specified pillar for a specified range of pages
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getFrontierRewardByPage(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.pillar.getFrontierRewardByPage', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }
}
