<?php

namespace EtherScan\Resources;

class Account extends AbstractHttpResource
{
    const MODULE = 'account';
    const PAGE_SIZE = 25;

    public function getBalance(string $address, bool $testMode = false)
    {
        $action = 'balance';
        $queryParams = [
            'address' => $address,
            'tag' => 'latest'
        ];
        $this->apiConnector->generateLink(self::MODULE, $action, $testMode, $queryParams);
    }

    public function getBalances(array $addressList, bool $testMode = false)
    {
        $action = 'balancemulti';
        $queryParams = [
            'address' => implode(',', $addressList),
            'tag' => 'latest'
        ];
        $this->apiConnector->generateLink(self::MODULE, $action, $testMode, $queryParams);
    }

    public function getTransactions(string $address, int $page, bool $testMode = false)
    {
        $action = 'txlist';
        $queryParams = [
            'address' => $address,
            'offset' => self::PAGE_SIZE,
            'page' => $page + 1, //(page || 0) + 1, //
            'sort' => 'desc'
        ];
        $this->apiConnector->generateLink(self::MODULE, $action, $testMode, $queryParams);
    }

}