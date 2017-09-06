<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

abstract class AbstractHttpResource
{
    const RESOURCE_TX = 'tx';
    const RESOURCE_ADDRESS = 'address';
    const RESOURCE_API = 'api';

    protected $queryParams = [
        'module' => null,
        'action' => null,
    ];

    /** @var ApiConnector */
    protected $apiConnector;

    public function __construct(ApiConnector $apiConnector)
    {
        $this->apiConnector = $apiConnector;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

}