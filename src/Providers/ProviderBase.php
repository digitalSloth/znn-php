<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ProviderBase
{
    /**
     * @var Client $httpClient
     */
    protected Client $httpClient;

    /**
     * @var ResponseInterface $lastRequest
     */
    protected ResponseInterface $lastRequest;

    /**
     * @var array $result
     */
    protected array $result = [
        'status' => false,
        'data' => false,
    ];

    /**
     * @var bool $throwApiErrors
     */
    protected bool $throwApiErrors = false;

    /**
     * @param $httpClient
     * @param $throwApiErrors
     */
    public function __construct($httpClient, $throwApiErrors)
    {
        $this->httpClient = $httpClient;
        $this->throwApiErrors = $throwApiErrors;

        return $this;
    }

    /**
     * Makes a request to the zenon node via the http client.
     *
     * @param string $method
     * @param array $data
     * @return $this
     * @throws HttpException
     */
    protected function makeRequest(string $method, array $data = []): static
    {
        try {
            $this->lastRequest = $this->httpClient->post('', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'id' => 0,
                    'method' => $method,
                    'params' => $data,
                ],
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            throw new HttpException($exception->getMessage());
        }

        return $this;
    }

    /**
     * Processes the response from the zenon node
     *
     * @return $this
     * @throws ApiException
     */
    protected function processResponse(): static
    {
        if ($this->lastRequest->getStatusCode() === 200) {

            $response = $this->lastRequest
                ->getBody()
                ->getContents();

            $data = json_decode($response);

            if (isset($data->error)) {
                $this->result['data'] = $data->error;

                if ($this->throwApiErrors) {
                    throw new ApiException($data->error->message);
                }
            } elseif ($data->result) {
                $this->result['status'] = true;
                $this->result['data'] = $data->result;
            }
        }

        return $this;
    }
}
