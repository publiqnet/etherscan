<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

class Stats extends AbstractHttpResource
{

    public function __construct(ApiConnector $apiConnector)
    {
        parent::__construct($apiConnector);
        $this->queryParams['action'] = 'stats';
    }


    public function getEthPrice()
    {
        $this->queryParams['module'] = 'ethprice';
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

    public function getEthSupply()
    {
        $this->queryParams['module'] = 'ethsupply';
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

}