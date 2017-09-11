<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;

/**
 * Class Stats
 * @package EtherScan\Modules
 *
 * Represents the stats module of the etherscan.io api
 */
class Stats extends AbstractHttpResource
{
    private $queryParams = ['module' => 'stats'];

    /**
     * @return string
     */
    public function getEthPrice(): string
    {
        $url = $this->getEthPriceLink();
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @return string
     */
    public function getEthPriceLink()
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethprice']);
        return $this->apiConnector->generateLink(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery
        );
    }

    /**
     * @return string
     */
    public function getEthSupply(): string
    {
        $url = $this->getEthSupplyLink();
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @return string
     */
    public function getEthSupplyLink()
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethsupply']);
        return $this->apiConnector->generateLink(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery
        );
    }

}