<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Accelerator extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAll(int $page = 0, int $perPage = 1000): array
    {
        $this->makeRequest('embedded.accelerator.getAll', [$page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $id
     * @return array
     * @throws ApiException|HttpException
     */
    public function getProjectById(string $id): array
    {
        $this->makeRequest('embedded.accelerator.getProjectById', [$id])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $id
     * @return array
     * @throws ApiException|HttpException
     */
    public function getPhaseById(string $id): array
    {
        $this->makeRequest('embedded.accelerator.getPhaseById', [$id])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $pillarName
     * @param array $projectHashes
     * @return array
     * @throws ApiException|HttpException
     */
    public function getPillarVotes(string $pillarName, array $projectHashes = []): array
    {
        $this->makeRequest('embedded.accelerator.getPillarVotes', [$pillarName, $projectHashes])
            ->processResponse();

        if ($this->result['status']) {

            $_result = [];

            foreach ($this->result['data'] as $votes) {
                //0 = Yes | 1 = No | 2 = Abstain
                $vote = null;
                if($votes->vote === 0) {
                    $vote = true;
                } elseif($votes->vote === 1) {
                    $vote = false;
                }

                $_result[$votes->id] = [
                    'vote' => $vote,
                ];
            }

            $this->result['data'] = $_result;
        }

        return $this->result;
    }

    /**
     * @param string $hash
     * @return array
     * @throws ApiException|HttpException
     */
    public function getVoteBreakdown(string $hash): array
    {
        $this->makeRequest('embedded.accelerator.getVoteBreakdown', [$hash])
            ->processResponse();

        return $this->result;
    }
}
