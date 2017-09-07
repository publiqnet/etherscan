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
            'tag' => 'latest'
        ]);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    /**
     * @param string $address
     * @param callable $resolveHandler
     * @param callable $rejectHandler
     */
    public function getBalanceAsync(string $address,
                                    callable $resolveHandler, callable $rejectHandler)
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balance',
            'address' => $address,
            'tag' => 'latest'
        ]);
        $this->apiConnector->doRequestAsync(AbstractHttpResource::RESOURCE_API, $finalQuery,
            $resolveHandler, $rejectHandler);
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
     * @param array $addressList
     * @param callable $resolveHandler
     * @param callable $rejectHandler
     */
    public function getBalancesAsync(array $addressList,
                                     callable $resolveHandler, callable $rejectHandler)
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balancemulti',
            'address' => implode(',', $addressList),
            'tag' => 'latest'
        ]);
        $this->apiConnector->doRequestAsync(AbstractHttpResource::RESOURCE_API, $finalQuery,
            $resolveHandler, $rejectHandler);
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
            'page' => $page + 1,
            'sort' => 'desc'
        ]);
        return $this->apiConnector->doRequest(AbstractHttpResource::RESOURCE_API, $finalQuery);
    }

    /**
     * @param string $address
     * @param int $page
     * @param int $pageSize
     * @param callable $resolveHandler
     * @param callable $rejectHandler
     */
    public function getTransactionsAsync(string $address, int $page, int $pageSize,
                                         callable $resolveHandler, callable $rejectHandler)
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'txlist',
            'address' => $address,
            'offset' => $pageSize,
            'page' => $page + 1,
            'sort' => 'desc'
        ]);
        $this->apiConnector->doRequestAsync(AbstractHttpResource::RESOURCE_API, $finalQuery,
            $resolveHandler, $rejectHandler);
    }

}