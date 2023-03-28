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
     * @var HttpClient|WsClient $client
     */
    protected $client;

    /**
     * @var bool $throwErrors
     */
    protected bool $throwErrors = false;

    /**
     * @var bool $isWsConnection
     */
    protected $isWsConnection;

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
     * @param $client
     * @param $throwErrors
     * @param $isWsConnection
     */
    public function __construct($client, $throwErrors, $isWsConnection)
    {
        $this->client = $client;
        $this->throwErrors = $throwErrors;
        $this->isWsConnection = $isWsConnection;

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
        if ($this->isWsConnection) {
            $this->makeWsRequest($method, $data);
        } else {
            $this->makeHttpRequest($method, $data);
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
        if ($this->isWsConnection) {
            $response = $this->processWsResponse();
        } else {
            $response = $this->processHttpResponse();
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
            $this->client->send(json_encode([
                'jsonrpc' => '2.0',
                'id' => 0,
                'method' => $method,
                'params' => $data,
            ]));
            $this->lastRequest = $this->client->receive();
            $this->client->close();
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
        if ($this->lastRequest && $this->lastRequest->getStatusCode() === 200) {
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
