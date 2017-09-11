<?php

namespace EtherScan\Resources;

use Exception;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\HttpClient\Client;
use React\HttpClient\Response;

/**
 * Does all the calls to the etherscan.io
 *
 * Class ApiConnector
 * @package EtherScan\Resources
 */
class ApiConnector
{
    /** @var resource */
    private $ch;
    /** @var string */
    private $apiKey;
    /** @var Client */
    private $httpClient;
    /** @var LoopInterface */
    private $eventLoop;

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

        $this->eventLoop = Factory::create();
        $this->httpClient = new Client($this->eventLoop);
    }

    /**
     * @param string $prefix
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
     * @param string $url
     * @return string
     * @throws Exception
     */
    public function doRequest(string $url): string
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $result = curl_exec($this->ch);

        if ($result === false) {
            throw new Exception('Network error: ' . curl_error($this->ch));
        }

        return $result;
    }

    /**
     * Adds a task into the eventloop to be called asynchronous
     *
     * @param string $url
     * @param callable $resolve
     */
    public function enlistRequest(string $url, callable $onResponse, callable $onError, $context = null)
    {
        $request = $this->httpClient->request('GET', $url);
        /** @var callable $onResponse */
        $request->on('response',
            function (Response $response) use ($onResponse, $context){
                $response->on('data', function ($data) use ($onResponse, $context) {
                    $onResponse($data, $context);
                });
            });
        $request->on('error', $onError);
        $request->end();
    }

    /**
     * @return \React\EventLoop\ExtEventLoop|\React\EventLoop\LibEventLoop|\React\EventLoop\LibEvLoop|\React\EventLoop\StreamSelectLoop
     */
    public function getEventLoop()
    {
        return $this->eventLoop;
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