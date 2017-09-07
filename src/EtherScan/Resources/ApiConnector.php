<?php

namespace EtherScan\Resources;

use GuzzleHttp\Promise\Promise;

class ApiConnector
{
    /** @var resource */
    private $ch;
    /** @var string */
    private $apiKey;
    /** @var string */
    private $prefix;

    /** @var string */
    private $deferred;

    public function __construct(string $apiKey, string $prefix)
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);
        $this->apiKey = $apiKey;
        $this->prefix = $prefix;
    }

    /**
     * @param string $resource
     * @param array|null $queryParams
     * @return string
     */
    public function generateLink(string $resource, array $queryParams = null): string
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

    /**
     * @param string $resource
     * @param array|null $queryParams
     * @return string
     */
    public function doRequest(string $resource, array $queryParams = null): string
    {
        $url = $this->generateLink($resource, $queryParams);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $result = curl_exec($this->ch);

        return $result;
    }

    public function doRequestAsync(string $resource, array $queryParams, callable $resolve, callable $reject)
    {
        $promise = new Promise();
        $promise->then($resolve, $reject);

        $result = $this->doRequest($resource, $queryParams);
        $promise->resolve($result);
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