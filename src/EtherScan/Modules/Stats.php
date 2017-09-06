<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;

class Stats extends AbstractHttpResource
{
    private $queryParams = ['module' => 'stats'];

    /**
     * @return string
     */
    public function getEthPrice(): string
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethprice']);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    /**
     * @return string
     */
    public function getEthSupply(): string
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethsupply']);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

}