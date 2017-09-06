<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

abstract class AbstractHttpResource
{
    /** @var ApiConnector */
    private $apiConnector;

    public function __construct(ApiConnector $apiConnector)
    {
        $this->apiConnector = $apiConnector;
    }

}