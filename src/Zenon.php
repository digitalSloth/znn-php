<?php

namespace DigitalSloth\ZnnPhp;

use DigitalSloth\ZnnPhp\Providers\Accelerator;
use DigitalSloth\ZnnPhp\Providers\Ledger;
use DigitalSloth\ZnnPhp\Providers\Pillar;
use DigitalSloth\ZnnPhp\Providers\Plasma;
use DigitalSloth\ZnnPhp\Providers\Sentinel;
use DigitalSloth\ZnnPhp\Providers\Stake;
use DigitalSloth\ZnnPhp\Providers\Stats;
use DigitalSloth\ZnnPhp\Providers\Swap;
use DigitalSloth\ZnnPhp\Providers\Token;
use GuzzleHttp\Client as HttpClient;
use WebSocket\Client as WsClient;

class Zenon
{
    /**
     * @var string $nodeUrl
     */
    protected string $nodeUrl;

    /**
     * @var ?HttpClient
     */
    protected ?HttpClient $httpClient = null;

    /**
     * @var ?WsClient
     */
    protected ?WsClient $wsClient = null;

    /**
     * @var Pillar
     */
    public Pillar $pillar;

    /**
     * @var Plasma
     */
    public Plasma $plasma;

    /**
     * @var Accelerator
     */
    public Accelerator $accelerator;

    /**
     * @var Sentinel
     */
    public Sentinel $sentinel;

    /**
     * @var Stake
     */
    public Stake $stake;

    /**
     * @var Swap
     */
    public Swap $swap;

    /**
     * @var Token
     */
    public Token $token;

    /**
     * @var Ledger
     */
    public Ledger $ledger;

    /**
     * @var Stats
     */
    public Stats $stats;

    /**
     * @param string $nodeUrl
     * @param bool $throwErrors
     */
    public function __construct(string $nodeUrl = '127.0.0.1:35997', bool $throwErrors = false)
    {
        $this->nodeUrl = $nodeUrl;
        $this->connect();

        $this->accelerator = new Accelerator($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->pillar = new Pillar($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->plasma = new Plasma($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->sentinel = new Sentinel($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->stake = new Stake($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->swap = new Swap($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->token = new Token($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->ledger = new Ledger($this->wsClient ?: $this->httpClient, $throwErrors);
        $this->stats = new Stats($this->wsClient ?: $this->httpClient, $throwErrors);

        return $this;
    }

    /**
     * Checks if the nodeUrl is a WS/WSS connection
     *
     * @return bool
     */
    protected function isWsConnection(): bool
    {
        return (substr($this->nodeUrl, 0, 5) === "ws://" || substr($this->nodeUrl, 0, 6) === 'wss://');
    }

    /**
     * Connections to the relevant node client
     *
     * @return void
     */
    private function connect(): void
    {
        if ($this->isWsConnection()) {
            $this->wsClient = new WsClient($this->nodeUrl);
        } else {
            $this->httpClient = new HttpClient([
                'base_uri' => $this->nodeUrl,
                'timeout' => 2.0,
            ]);
        }
    }
}
