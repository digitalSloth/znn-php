<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;

class Token extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return a list of all ZTS tokens.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getAll(int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.token.getAll', [$page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the list of ZTS issued by an address.
     *
     * @param string $address
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws ApiException|HttpException
     */
    public function getByOwner(string $address, int $page = 0, int $perPage = 100): array
    {
        $this->makeRequest('embedded.token.getByOwner', [$address, $page, $perPage])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return the ZTS with the specified unique identifier
     *
     * @param string $token
     * @return array
     * @throws ApiException|HttpException
     */
    public function getByZts(string $token): array
    {
        $this->makeRequest('embedded.token.getByZts', [$token])
            ->processResponse();

        return $this->result;
    }
}
