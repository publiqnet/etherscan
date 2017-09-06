<?php

namespace EtherScan;

class ApiConnector
{
    const PREFIX_DEFAULT = 'testnet';
    const PREFIX_ROPSTEN = 'ropsten';
    const PREFIX_RINKEBY = 'rinkeby';
    const PREFIX_KOVAN = 'kovan';

    const RESOURCE_TX = 'tx';
    const RESOURCE_ADDRESS = 'address';
    const RESOURCE_API = 'api';

    const URL_PATTERN = 'https://%s.etherscan.io/%s/';

    /** @var ApiConnector */
    private static $instance;
    /** @var resource */
    private $ch;

    private function __construct()
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_CUSTOMREQUEST => ['Accept: application/json'],
            CURLOPT_HEADER => 'GET',
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ]);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function generateLink(string $prefix, string $path, string $query)
    {
        return sprintf(self::URL_PATTERN, $prefix, $path, $query);
    }

    public function doRequest(string $url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $result = curl_exec($this->ch);

        return $result;
    }

    public function close()
    {
        curl_close($this->ch);
    }

    public function __destruct()
    {
        $this->close();
    }

}