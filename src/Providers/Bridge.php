<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Bridge extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @return array
     * @throws Exception
     */
    public function getBridgeInfo(): array
    {
        $this->makeRequest('embedded.bridge.getBridgeInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSecurityInfo(): array
    {
        $this->makeRequest('embedded.bridge.getSecurityInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOrchestratorInfo(): array
    {
        $this->makeRequest('embedded.bridge.getOrchestratorInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTimeChallengesInfo(): array
    {
        $this->makeRequest('embedded.bridge.getTimeChallengesInfo')
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $networkClass
     * @param int $chainId
     * @return array
     * @throws Exception
     */
    public function getNetworkInfo(int $networkClass, int $chainId): array
    {
        $this->makeRequest('embedded.bridge.getNetworkInfo', [$networkClass, $chainId])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function getAllNetworks(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllNetworks', [$pageIndex, $pageSize])
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
    public function getWrapTokenRequestById(string $id): array
    {
        $this->makeRequest('embedded.bridge.getWrapTokenRequestById', [$id])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function getAllWrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllWrapTokenRequests', [$pageIndex, $pageSize])
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
    public function getAllWrapTokenRequestsByToAddress(string $toAddress, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllWrapTokenRequestsByToAddress', [$toAddress, $pageIndex, $pageSize])
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
    public function getAllWrapTokenRequestsByToAddressNetworkClassAndChainId(string $toAddress, string $networkClass, int $pageIndex, int $pageSize): array
    {
        $this->makeRequest('embedded.bridge.getAllWrapTokenRequestsByToAddressNetworkClassAndChainId', [$toAddress, $networkClass, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function getAllUnsignedWrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllUnsignedWrapTokenRequests', [$pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $txHash
     * @param int $logIndex
     * @return array
     * @throws Exception
     */
    public function getUnwrapTokenRequestByHashAndLog(string $txHash, int $logIndex): array
    {
        $this->makeRequest('embedded.bridge.getUnwrapTokenRequestByHashAndLog', [$txHash, $logIndex])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @return array
     * @throws Exception
     */
    public function getAllUnwrapTokenRequests(int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllUnwrapTokenRequests', [$pageIndex, $pageSize])
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
    public function getAllUnwrapTokenRequestsByToAddress(string $toAddress, int $pageIndex = 0, int $pageSize = 1000): array
    {
        $this->makeRequest('embedded.bridge.getAllUnwrapTokenRequestsByToAddress', [$toAddress, $pageIndex, $pageSize])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $zts
     * @return array
     * @throws Exception
     */
    public function getFeeTokenPair(string $zts): array
    {
        $this->makeRequest('embedded.bridge.getFeeTokenPair', [$zts])
            ->processResponse();

        return $this->result;
    }
}
