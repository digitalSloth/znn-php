<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;
use DigitalSloth\ZnnPhp\Exceptions\WsException;
use GuzzleHttp\Client as HttpClient;

class ProviderBase
{
    /**
     * @var HttpClient $client
     */
    protected HttpClient $client;

    /**
     * @var bool $throwErrors
     */
    protected bool $throwErrors = false;

    /**
     * @var mixed $lastRequest
     */
    protected mixed $lastRequest = null;

    /**
     * @var array $result
     */
    protected array $result = [
        'status' => false,
        'data' => false,
    ];

    /**
     * @param $client
     * @param $throwErrors
     */
    public function __construct($client, $throwErrors)
    {
        $this->client = $client;
        $this->throwErrors = $throwErrors;
    }

    /**
     * Checks if the connection is ws or http and makes the relevant request.
     *
     * @param string $method
     * @param array $data
     * @return $this
     * @throws HttpException|WsException
     */
    protected function makeRequest(string $method, array $data = []): ProviderBase
    {
        try {
            $this->lastRequest = $this->client->post('', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'id' => 0,
                    'method' => $method,
                    'params' => $data,
                ],
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            if ($this->throwErrors) {
                throw new HttpException($exception->getMessage());
            }
        }

        return $this;
    }

    /**
     * Processes response from the zenon node
     *
     * @return $this
     * @throws ApiException
     */
    protected function processResponse(): ProviderBase
    {
        $response = null;

        if ($this->lastRequest && $this->lastRequest->getStatusCode() === 200) {
            $response = $this->lastRequest
                ->getBody()
                ->getContents();
        }

        if ($response) {
            $data = json_decode($response);

            if (isset($data->error)) {
                $this->result['data'] = $data->error;

                if ($this->throwErrors) {
                    throw new ApiException($data->error->message);
                }
            } else {
                $this->result['status'] = true;
                $this->result['data'] = $data->result;
            }
        }

        return $this;
    }
}
