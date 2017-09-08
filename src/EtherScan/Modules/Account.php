<?php

namespace EtherScan\Modules;

use EtherScan\Resources\AbstractHttpResource;
use InvalidArgumentException;

class Account extends AbstractHttpResource
{
    const SORT_DESC = 'desc';
    const SORT_ASC = 'asc';

    private $queryParams = ['module' => 'account'];

    /**
     * @param string $address
     * @return string
     */
    public function getBalance(string $address): string
    {
        $url = $this->getBalanceLink($address);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param string $address
     */
    public function getBalanceLink(string $address)
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balance',
            'address' => $address,
            'tag' => 'latest'
        ]);
        return $this->apiConnector->generateLink(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery
        );
    }

    /**
     * @param array $addressList
     * @return string
     */
    public function getBalances(array $addressList): string
    {
        $url = $this->getBalancesLink($addressList);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param array $addressList
     * @return string
     */
    public function getBalancesLink(array $addressList)
    {
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'balancemulti',
            'address' => implode(',', $addressList),
            'tag' => 'latest'
        ]);
        return $this->apiConnector->generateLink(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery
        );
    }

    /**
     * @param string $address
     * @param int $page
     * @param int $pageSize
     * @return string
     */
    public function getTransactions(string $address, int $page, int $pageSize, string $sort): string
    {
        $url = $this->getTransactionsLink($address, $page, $pageSize, $sort);
        return $this->apiConnector->doRequest($url);
    }

    /**
     * @param string $address
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @return string
     * @throws InvalidArgumentException
     */
    public function getTransactionsLink(string $address, int $page, int $pageSize, string $sort)
    {
        if ($sort != Account::SORT_ASC && $sort != Account::SORT_DESC) {
            throw new InvalidArgumentException('Argument sort is invalid');
        }
        $finalQuery = array_merge($this->queryParams, [
            'action' => 'txlist',
            'address' => $address,
            'offset' => $pageSize,
            'page' => $page,
            'sort' => $sort
        ]);
        return $this->apiConnector->generateLink(
            $this->prefix, AbstractHttpResource::RESOURCE_API, $finalQuery
        );
    }

}