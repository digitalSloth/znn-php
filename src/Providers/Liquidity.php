<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Liquidity extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @return array
     * @throws Exception
     */
    public function GetLiquidityInfo(): array
    {
        $this->makeRequest('embedded.liquidity.GetLiquidityInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetSecurityInfo(): array
    {
        $this->makeRequest('embedded.liquidity.GetSecurityInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $address
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetLiquidityStakeEntriesByAddress(string $address, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.liquidity.GetLiquidityStakeEntriesByAddress', [$address, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $address
     * @return array
     * @throws Exception
     */
    public function GetUncollectedReward(string $address): array
    {
        $this->makeRequest('embedded.liquidity.GetUncollectedReward', [$address])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $address
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetFrontierRewardByPage(string $address, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.liquidity.GetFrontierRewardByPage', [$address, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetTimeChallengesInfo(): array
    {
        $this->makeRequest('embedded.liquidity.GetTimeChallengesInfo')
            ->processResponse();

        return $this->result;
    }
}
