<?php

namespace EtherScan;

use EtherScan\Modules\Account;
use EtherScan\Modules\Stats;
use EtherScan\Resources\AbstractHttpResource;
use EtherScan\Resources\ApiConnector;

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

    public function __construct(ApiConnector $apiConnector)
    {
        $this->apiConnector = $apiConnector;
        $this->stats = new Stats($this->apiConnector);
        $this->account = new Account($this->apiConnector);
    }

    /**
     * @return Stats
     */
    public function getStats(): Stats
    {
        return $this->stats;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param string $hash
     * @return string
     */
    public function getTxLink(string $hash): string
    {
        return $this->apiConnector->generateLink(AbstractHttpResource::RESOURCE_TX . '/' . $hash);
    }

    /**
     * @param string $address
     * @return string
     */
    public function getAddressLink(string $address): string
    {
        return $this->apiConnector->generateLink(AbstractHttpResource::RESOURCE_ADDRESS . '/' . $address);
    }

}