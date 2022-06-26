<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Stake extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return staking information for a particular address.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getEntriesByAddress(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.stake.getEntriesByAddress', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the uncollected reward(s) for the specified stake.
     *
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function getUncollectedReward(string $address): array
    {
        $this->makeRequest('embedded.stake.getUncollectedReward', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return reward information the specified stake for a specified range of pages.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
     */
    public function getFrontierRewardByPage(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.stake.getFrontierRewardByPage', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }
}
