<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

class Stats extends AbstractHttpResource
{

    public function __construct(ApiConnector $apiConnector)
    {
        parent::__construct($apiConnector);
        $this->queryParams['module'] = 'stats';
    }


    public function getEthPrice()
    {
        $this->queryParams['action'] = 'ethprice';
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

    public function getEthSupply()
    {
        $this->queryParams['action'] = 'ethsupply';
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

}