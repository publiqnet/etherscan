<?php

namespace EtherScan;

class ApiConnector
{
    /** @var ApiConnector */
    private static $instance;
    /** @var resource */
    private $ch;
    /** @var string */
    private $apiKey;
    /** @var string */
    private $prefix;

    private function __construct(string $apiKey, string $prefix)
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_CUSTOMREQUEST => ['Accept: application/json'],
            CURLOPT_HEADER => 'GET',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);
        $this->apiKey = $apiKey;
        $this->prefix = $prefix;
    }

    public static function getInstance(string $apiKey, string $prefix)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($apiKey, $prefix);
        }
        return self::$instance;
    }

    public function generateLink(string $resource, array $queryParams = null)
    {
        $query = '';
        if (is_array($queryParams) && count($queryParams) > 0) {
            $queryParams['apiKey'] = $this->apiKey;
            $query = '?' . http_build_query($queryParams);
        }

        $url = sprintf('https://%s.etherscan.io/%s%s',
            $this->prefix, $resource, $query
        );

        return $url;
    }

    public function doRequest(string $resource, array $queryParams = null)
    {
        if (is_array($queryParams) &&
            !isset($queryParams['module'], $queryParams['action'], $queryParams['apiToken'])
        ) {

            throw new \InvalidArgumentException('Missing/Invalid query parameters');
        }

        $url = $this->generateLink($resource, $queryParams);
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