<?php

namespace DigitalSloth\ZnnPhp;

use DigitalSloth\ZnnPhp\Providers\Accelerator;
use DigitalSloth\ZnnPhp\Providers\Bridge;
use DigitalSloth\ZnnPhp\Providers\Htlc;
use DigitalSloth\ZnnPhp\Providers\Ledger;
use DigitalSloth\ZnnPhp\Providers\Liquidity;
use DigitalSloth\ZnnPhp\Providers\Pillar;
use DigitalSloth\ZnnPhp\Providers\Plasma;
use DigitalSloth\ZnnPhp\Providers\Sentinel;
use DigitalSloth\ZnnPhp\Providers\Stake;
use DigitalSloth\ZnnPhp\Providers\Stats;
use DigitalSloth\ZnnPhp\Providers\Swap;
use DigitalSloth\ZnnPhp\Providers\Token;
use GuzzleHttp\Client as HttpClient;

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
     * @var Accelerator
     */
    public Accelerator $accelerator;

    /**
     * @var Bridge
     */
    public Bridge $bridge;

    /**
     * @var Htlc
     */
    public Htlc $htlc;

    /**
     * @var Ledger
     */
    public Ledger $ledger;

    /**
     * @var Liquidity
     */
    public Liquidity $liquidity;

    /**
     * @var Pillar
     */
    public Pillar $pillar;

    /**
     * @var Plasma
     */
    public Plasma $plasma;

    /**
     * @var Sentinel
     */
    public Sentinel $sentinel;

    /**
     * @var Stake
     */
    public Stake $stake;

    /**
     * @var Stats
     */
    public Stats $stats;

    /**
     * @var Swap
     */
    public Swap $swap;

    /**
     * @var Token
     */
    public Token $token;

    /**
     * @param string $nodeUrl
     * @param bool $throwErrors
     */
    public function __construct(string $nodeUrl = '127.0.0.1:35997', bool $throwErrors = false)
    {
        $this->nodeUrl = $nodeUrl;
        $this->connect();

        $this->accelerator = new Accelerator($this->httpClient, $throwErrors);
        $this->bridge = new Bridge($this->httpClient, $throwErrors);
        $this->htlc = new Htlc($this->httpClient, $throwErrors);
        $this->ledger = new Ledger($this->httpClient, $throwErrors);
        $this->liquidity = new Liquidity($this->httpClient, $throwErrors);
        $this->pillar = new Pillar($this->httpClient, $throwErrors);
        $this->plasma = new Plasma($this->httpClient, $throwErrors);
        $this->sentinel = new Sentinel($this->httpClient, $throwErrors);
        $this->stake = new Stake($this->httpClient, $throwErrors);
        $this->stats = new Stats($this->httpClient, $throwErrors);
        $this->swap = new Swap($this->httpClient, $throwErrors);
        $this->token = new Token($this->httpClient, $throwErrors);
    }

    /**
     * Connections to the relevant node client
     *
     * @return void
     */
    private function connect(): void
    {
        $this->httpClient = new HttpClient([
            'base_uri' => $this->nodeUrl,
        ]);
    }
}
