<?php

namespace EtherScan\Resources;

abstract class AbstractHttpResource
{
    const RESOURCE_TX = 'tx';
    const RESOURCE_ADDRESS = 'address';
    const RESOURCE_API = 'api';

    protected $prefix;

    /** @var ApiConnector */
    protected $apiConnector;

    public function __construct(ApiConnector $apiConnector, string $prefix)
    {
        $this->apiConnector = $apiConnector;
        $this->prefix = $prefix;
    }

}