<?php

namespace DigitalSloth\ZnnPhp;

use DigitalSloth\ZnnPhp\Providers\Accelerator;
use DigitalSloth\ZnnPhp\Providers\Htlc;
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
     * @var Htlc
     */
    public Htlc $htlc;

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

        $isWsConnection = $this->isWsConnection();
        $client = ($isWsConnection
            ? $this->wsClient
            : $this->httpClient);

        $this->accelerator = new Accelerator($client, $throwErrors, $isWsConnection);
        $this->htlc = new Htlc($client, $throwErrors, $isWsConnection);
        $this->pillar = new Pillar($client, $throwErrors, $isWsConnection);
        $this->plasma = new Plasma($client, $throwErrors, $isWsConnection);
        $this->sentinel = new Sentinel($client, $throwErrors, $isWsConnection);
        $this->stake = new Stake($client, $throwErrors, $isWsConnection);
        $this->swap = new Swap($client, $throwErrors, $isWsConnection);
        $this->token = new Token($client, $throwErrors, $isWsConnection);
        $this->ledger = new Ledger($client, $throwErrors, $isWsConnection);
        $this->stats = new Stats($client, $throwErrors, $isWsConnection);

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
