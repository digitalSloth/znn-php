<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\Exception;

class Stats extends \DigitalSloth\ZnnPhp\Providers\ProviderBase
{
    /**
     * This API call will return information about the os.
     *
     * @return array
     * @throws Exception
     */
    public function osInfo(): array
    {
        $this->makeRequest('stats.osInfo', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the runtime.
     *
     * @return array
     * @throws Exception
     */
    public function runtimeInfo(): array
    {
        $this->makeRequest('stats.runtimeInfo', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the process.
     *
     * @return array
     * @throws Exception
     */
    public function processInfo(): array
    {
        $this->makeRequest('stats.processInfo', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the sync status.
     *
     * @return array
     * @throws Exception
     */
    public function syncInfo(): array
    {
        $this->makeRequest('stats.syncInfo', [])
            ->processResponse();

        return $this->result;
    }

    /**
     * This API call will return information about the network.
     *
     * @return array
     * @throws Exception
     */
    public function networkInfo(): array
    {
        $this->makeRequest('stats.networkInfo', [])
            ->processResponse();

        return $this->result;
    }
}
