<?php

namespace EtherScan;

class EtherScan
{
    const PREFIX_DEFAULT = 'testnet';
    const PREFIX_ROPSTEN = 'ropsten';
    const PREFIX_RINKEBY = 'rinkeby';
    const PREFIX_KOVAN = 'kovan';

    const RESOURCE_TX = 'tx';
    const RESOURCE_ADDRESS = 'address';
    const RESOURCE_API = 'api';

    const URL_PATTERN = 'https://%s.etherscan.io/%s/';

    /** @var Stats */
    private $stats;
    /** @var Account */
    private $account;

    public function __construct()
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => ['Accept: application/json'],
            CURLOPT_HEADER => 'GET',
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ]);

        $this->stats = new Stats($ch);
        $this->account = new Account($ch);
    }

    /**
     * @return Stats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    public function getTxLink(string $hash)
    {
        return $this->generateLink('', self::RESOURCE_TX, $hash);
    }

    public function getAddressLink(string $address)
    {
        return $this->generateLink('', self::RESOURCE_TX, $address);
    }

    private function generateLink(string $prefix, string $path, string $query)
    {
        return sprintf(self::URL_PATTERN, $prefix, $path, $query);
    }

}