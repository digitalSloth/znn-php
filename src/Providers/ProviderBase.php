<?php

namespace DigitalSloth\ZnnPhp\Providers;

use DigitalSloth\ZnnPhp\Exceptions\ApiException;
use DigitalSloth\ZnnPhp\Exceptions\HttpException;
use DigitalSloth\ZnnPhp\Exceptions\WsException;
use GuzzleHttp\Client as HttpClient;
use WebSocket\Client as WsClient;

class ProviderBase
{
    /**
     * @var HttpClient|WsClient $requestClient
     */
    protected $requestClient;

    /**
     * @var mixed $lastRequest
     */
    protected $lastRequest;

    /**
     * @var array $result
     */
    protected array $result = [
        'status' => false,
        'data' => false,
    ];

    /**
     * @var bool $throwErrors
     */
    protected bool $throwErrors = false;

    /**
     * @param $requestClient
     * @param $throwErrors
     */
    public function __construct($requestClient, $throwErrors)
    {
        $this->requestClient = $requestClient;
        $this->throwErrors = $throwErrors;

        return $this;
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
        if ($this->requestClient instanceof HttpClient) {
            $this->makeHttpRequest($method, $data);
        } elseif ($this->requestClient instanceof WsClient) {
            $this->makeWsRequest($method, $data);
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
        $response = false;

        if ($this->requestClient instanceof HttpClient) {
            $response = $this->processHttpResponse();
        } elseif ($this->requestClient instanceof WsClient) {
            $response = $this->processWsResponse();
        }

        if($response) {
            $data = json_decode($response);

            if (isset($data->error)) {
                $this->result['data'] = $data->error;

                if ($this->throwErrors) {
                    throw new ApiException($data->error->message);
                }
            } elseif ($data->result) {
                $this->result['status'] = true;
                $this->result['data'] = $data->result;
            }
        }

        return $this;
    }

    /**
     * Sends a http request to the node.
     *
     * @param string $method
     * @param array $data
     * @return void
     * @throws HttpException
     */
    private function makeHttpRequest(string $method, array $data): void
    {
        try {
            $this->lastRequest = $this->requestClient->post('', [
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
    }

    /**
     * Sends a ws request to the node.
     *
     * @param string $method
     * @param array $data
     * @return void
     * @throws WsException
     */
    private function makeWsRequest(string $method, array $data): void
    {
        try {
            $this->requestClient->send(json_encode([
                'jsonrpc' => '2.0',
                'id' => 0,
                'method' => $method,
                'params' => $data,
            ]));
            $this->lastRequest = $this->requestClient->receive();
            $this->requestClient->close();
        } catch (\WebSocket\Exception $exception) {
            if ($this->throwErrors) {
                throw new WsException($exception->getMessage());
            }
        }
    }

    /**
     * Returns response from the http client if we got a success code.
     *
     * @return ?string
     */
    private function processHttpResponse(): ?string
    {
        if ($this->lastRequest->getStatusCode() === 200) {
            return $this->lastRequest
                ->getBody()
                ->getContents();
        }

        return null;
    }

    /**
     * Returns response from the ws client.
     *
     * @return ?string
     */
    private function processWsResponse(): ?string
    {
        return $this->lastRequest;
    }
}
