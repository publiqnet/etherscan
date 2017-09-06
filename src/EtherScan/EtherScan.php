<?php

namespace EtherScan;

use EtherScan\Resources\AbstractHttpResource;
use EtherScan\Resources\Account;
use EtherScan\Resources\Stats;

class EtherScan
{
    const MODE_API = 'api';
    const MODE_TESTNET = 'testnet';
    const MODE_ROPSTEN = 'ropsten';
    const MODE_RINKEBY = 'rinkeby';
    const MODE_KOVAN = 'kovan';

    /** @var Stats */
    private $stats;
    /** @var Account */
    private $account;
    /** @var ApiConnector */
    private $apiConnector;

    public function __construct(string $apiKey, string $mode = self::MODE_API)
    {
        $this->apiConnector = ApiConnector::getInstance($apiKey, $mode);
        $this->stats = new Stats($this->apiConnector);
        $this->account = new Account($this->apiConnector);
    }

    /**
     * @return Stats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    public function getTxLink(string $hash)
    {
        return $this->apiConnector->generateLink(AbstractHttpResource::RESOURCE_TX . '/' . $hash);
    }

    public function getAddressLink(string $address)
    {
        return $this->apiConnector->generateLink(AbstractHttpResource::RESOURCE_ADDRESS . '/' . $address);
    }

}