<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Ptlc extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function getById(string $id): array
    {
        $this->makeRequest('embedded.ptlc.getById', [$id])
            ->processResponse();

        return $this->result;
    }
}
