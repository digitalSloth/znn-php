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
use GuzzleHttp\Client;

class Zenon
{
    /**
     * @var Client
     */
    protected Client $httpClient;

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
     * @param string $host
     * @param bool $throwApiErrors
     */
	public function __construct(string $host = '127.0.0.1:35997', bool $throwApiErrors = false)
	{
		$this->httpClient = new Client([
			'base_uri' => $host,
			'timeout' => 2.0,
		]);

        $this->accelerator = new Accelerator($this->httpClient, $throwApiErrors);
        $this->pillar = new Pillar($this->httpClient, $throwApiErrors);
        $this->plasma = new Plasma($this->httpClient, $throwApiErrors);
        $this->sentinel = new Sentinel($this->httpClient, $throwApiErrors);
        $this->stake = new Stake($this->httpClient, $throwApiErrors);
        $this->swap = new Swap($this->httpClient, $throwApiErrors);
        $this->token = new Token($this->httpClient, $throwApiErrors);
        $this->ledger = new Ledger($this->httpClient, $throwApiErrors);
        $this->stats = new Stats($this->httpClient, $throwApiErrors);

		return $this;
	}
}
