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

    /** @var ApiConnector */
    private static $instance;
    /** @var resource */
    private $ch;
    /** @var string */
    private $apiKey;

    private function __construct(string $apiKey)
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_CUSTOMREQUEST => ['Accept: application/json'],
            CURLOPT_HEADER => 'GET',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
        $this->apiKey = $apiKey;
    }

    public static function getInstance(string $apiKey)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($apiKey);
        }
        return self::$instance;
    }

    public function generateLink(string $module, string $action, bool $testMode, array $queryParams = null)
    {
        $defaultQuery = [
            'module' => $module,
            'action' => $action,
            'apiKey' => $this->apiKey,
        ];
        $query = array_merge($defaultQuery, $queryParams);
        return sprintf('https://%s.etherscan.io/?%s', 'api', http_build_query($query));
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