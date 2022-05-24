<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Swap extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return the amount of ZNN and QSR that have not been swapped yet.
     *
     * @param string $idKey
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAssetsByKeyIdHash(string $idKey): array
    {
        $this->makeRequest('embedded.swap.getAssetsByKeyIdHash', [$idKey])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return for every keyId hash the amount of znn or qsr that can be swapped.
     *
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAssets(): array
    {
        $this->makeRequest('embedded.swap.getAssets', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the number of legacy Pillars not swapped yet.
     *
     * @return array
     * @throws ApiException|HttpException
     */
    public function getLegacyPillars(): array
    {
        $this->makeRequest('embedded.swap.getLegacyPillars', [])
            ->processResponse();

        return $this->result;
    }
}
