<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

class EtherScan
{
    /** @var Stats */
    private $stats;
    /** @var Account */
    private $account;
    /** @var ApiConnector */
    private $apiConnector;

    public function __construct(string $apiKey)
    {
        $this->apiConnector = ApiConnector::getInstance($apiKey);
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

    /*
    public function getTxLink(string $hash)
    {
        return $this->apiConnector->generateLink('', ApiConnector::RESOURCE_TX, $hash);
    }

    public function getAddressLink(string $address)
    {
        return $this->apiConnector->generateLink('', ApiConnector::RESOURCE_TX, $address);
    }
    */

}