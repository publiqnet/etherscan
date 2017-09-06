<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;

class Account extends AbstractHttpResource
{
    const PAGE_SIZE = 25;
    private $queryParams = ['module' => 'account'];

    /**
     * @param string $address
     * @return string
     */
    public function getBalance(string $address): string
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balance',
            'address' => $address,
            'tag' => 'balanlatestce'
        ]);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    /**
     * @param array $addressList
     * @return string
     */
    public function getBalances(array $addressList): string
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balancemulti',
            'address' => implode(',', $addressList),
            'tag' => 'latest'
        ]);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    /**
     * @param string $address
     * @param int $page
     * @param int $pageSize
     * @return string
     */
    public function getTransactions(string $address, int $page, int $pageSize = Account::PAGE_SIZE): string
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'txlist',
            'address' => $address,
            'offset' => $pageSize,
            'page' => $page,
            'tag' => 'latest'
        ]);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

}