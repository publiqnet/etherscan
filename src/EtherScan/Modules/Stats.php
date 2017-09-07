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
        return $this->apiConnector->doRequest($this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    public function getEthPriceAsync(callable $resolveHandler, callable $rejectHandler)
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethprice']);
        $this->apiConnector->doRequestAsync(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery,
            $resolveHandler, $rejectHandler
        );
    }

    /**
     * @return string
     */
    public function getEthSupply(): string
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethsupply']);
        return $this->apiConnector->doRequest($this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    public function getEthSupplyAsync(callable $resolveHandler, callable $rejectHandler)
    {
        $finalQuery = array_merge($this->queryParams, ['action' => 'ethsupply']);
        $this->apiConnector->doRequestAsync(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery,
            $resolveHandler, $rejectHandler
        );
    }

}