<?php

namespace EtherScan\Resources;

use Exception;
use GuzzleHttp\Promise\Promise;

class ApiConnector
{
    /** @var resource */
    private $ch;
    /** @var string */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $resource
     * @param array|null $queryParams
     * @return string
     */
    public function generateLink(string $prefix, string $resource, array $queryParams = null): string
    {
        $query = '';
        if (is_array($queryParams) && count($queryParams) > 0) {
            $queryParams['apiKey'] = $this->apiKey;
            $query = '?' . http_build_query($queryParams);
        }

        $url = sprintf('https://%setherscan.io/%s%s',
            $prefix, $resource, $query
        );

        return $url;
    }

    /**
     * @param string $resource
     * @param array|null $queryParams
     * @return string
     */
    public function doRequest(string $prefix, string $resource, array $queryParams = null): string
    {
        $url = $this->generateLink($prefix, $resource, $queryParams);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $result = curl_exec($this->ch);

        if ($result === false) {
            throw new Exception('Network error: ' . curl_error($this->ch));
        }

        return $result;
    }

    /**
     * @param string $resource
     * @param array $queryParams
     * @param callable $resolve
     * @param callable $reject
     */
    public function doRequestAsync(string $prefix, string $resource, array $queryParams, callable $resolve,
                                   callable $reject)
    {
        $promise = new Promise();
        $promise->then($resolve, $reject);

        $result = $this->doRequest($prefix, $resource, $queryParams);
        $oResult = json_decode($result);

        if ($oResult->status == 1) {
            $promise->resolve($result);
        } else {
            $promise->reject($result);
        }
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