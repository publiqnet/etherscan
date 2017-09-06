<?php

namespace EtherScan\Resources;

use EtherScan\ApiConnector;

class Account extends AbstractHttpResource
{
    const PAGE_SIZE = 25;

    public function __construct(ApiConnector $apiConnector)
    {
        parent::__construct($apiConnector);
        $this->queryParams['action'] = 'account';
    }

    public function getBalance(string $address)
    {
        $this->queryParams['action'] = 'balance';
        $this->queryParams['address'] = $address;
        $this->queryParams['tag'] = 'latest';

        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

    public function getBalances(array $addressList)
    {
        $this->queryParams['action'] = 'balancemulti';
        $this->queryParams['address'] = implode(',', $addressList);
        $this->queryParams['tag'] = 'latest';

        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

    public function getTransactions(string $address, int $page)
    {
        $this->queryParams['action'] = 'txlist';
        $this->queryParams['address'] = $address;
        $this->queryParams['offset'] = self::PAGE_SIZE;
        $this->queryParams['page'] = $page + 1; //(page || 0) + 1, //
        $this->queryParams['tag'] = 'latest';

        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $this->queryParams);
    }

}