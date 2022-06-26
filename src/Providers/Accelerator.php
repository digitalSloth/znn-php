<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Accelerator extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function getPillarVotes(string $pillarName, array $projectHashes = []): array
    {
        $this->makeRequest('embedded.accelerator.getPillarVotes', [$pillarName, $projectHashes])
            ->processResponse();

        return $this->result;
    }

    /**
     * @param string $hash
     * @return array
     * @throws Exception
     */
    public function getVoteBreakdown(string $hash): array
    {
        $this->makeRequest('embedded.accelerator.getVoteBreakdown', [$hash])
            ->processResponse();

        return $this->result;
    }
}
