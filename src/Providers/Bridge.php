<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Bridge extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @return array
     * @throws Exception
     */
    public function GetBridgeInfo(): array
    {
        $this->makeRequest('embedded.bridge.GetBridgeInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetSecurityInfo(): array
    {
        $this->makeRequest('embedded.bridge.GetSecurityInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetOrchestratorInfo(): array
    {
        $this->makeRequest('embedded.bridge.GetOrchestratorInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function GetTimeChallengesInfo(): array
    {
        $this->makeRequest('embedded.bridge.GetTimeChallengesInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $networkClass
     * @param int $chainId
     * @return array
     * @throws Exception
     */
    public function GetNetworkInfo(int $networkClass, int $chainId): array
    {
        $this->makeRequest('embedded.bridge.GetNetworkInfo', [$networkClass, $chainId])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllNetworks(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllNetworks', [$pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $unwrapTokenRequest
     * @param string $tokenPair
     * @param string $momentum
     * @return array
     * @throws Exception
     */
    public function getRedeemableIn(string $unwrapTokenRequest, string $tokenPair, string $momentum): array
    {
        $this->makeRequest('embedded.bridge.getRedeemableIn', [$unwrapTokenRequest, $tokenPair, $momentum])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $wrapTokenRequest
     * @param int $confirmationsToFinality
     * @param string $momentum
     * @return array
     * @throws Exception
     */
    public function getConfirmationsToFinality(string $wrapTokenRequest, int $confirmationsToFinality, string $momentum): array
    {
        $this->makeRequest('embedded.bridge.getConfirmationsToFinality', [$wrapTokenRequest, $confirmationsToFinality, $momentum])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function GetWrapTokenRequestById(string $id): array
    {
        $this->makeRequest('embedded.bridge.GetWrapTokenRequestById', [$id])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllWrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllWrapTokenRequests', [$pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $toAddress
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllWrapTokenRequestsByToAddress(string $toAddress, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllWrapTokenRequestsByToAddress', [$toAddress, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $toAddress
     * @param string $networkClass
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllWrapTokenRequestsByToAddressNetworkClassAndChainId(string $toAddress, string $networkClass, int $pageIndex, int $pageSize): array
    {
        $this->makeRequest('embedded.bridge.GetAllWrapTokenRequestsByToAddressNetworkClassAndChainId', [$toAddress, $networkClass, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllUnsignedWrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllUnsignedWrapTokenRequests', [$pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $txHash
     * @param int $logIndex
     * @return array
     * @throws Exception
     */
    public function GetUnwrapTokenRequestByHashAndLog(string $txHash, int $logIndex): array
    {
        $this->makeRequest('embedded.bridge.GetUnwrapTokenRequestByHashAndLog', [$txHash, $logIndex])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllUnwrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllUnwrapTokenRequests', [$pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $toAddress
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function GetAllUnwrapTokenRequestsByToAddress(string $toAddress, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.GetAllUnwrapTokenRequestsByToAddress', [$toAddress, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $zts
     * @return array
     * @throws Exception
     */
    public function GetFeeTokenPair(string $zts): array
    {
        $this->makeRequest('embedded.bridge.GetFeeTokenPair', [$zts])
            ->processResponse();

        return $this->result;
    }
}
