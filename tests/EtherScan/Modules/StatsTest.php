<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\EtherScan;
use EtherScan\Modules\Stats;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';
    private $prefix = 'api.';
    private $conn;
    private $stats;
    private $getEthPriceAsyncResponce = [
            'status' => '1',
            'message' => 'OK',
            'result' => [
                'ethbtc' => '0.07197',
                'ethbtc_timestamp' => '1504795086',
                'ethusd' => '335.3',
                'ethusd_timestamp' => '1504795088',
            ]
    ];

    private $getEthSupplyAsyncResponce = [
            'status' => '1',
            'message' => 'OK',
            'result' => '94481993155300000000000000'
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
        $this->stats = new Stats($this->conn, $this->prefix);
    }

    public function testGetEthPrice()
    {
        $responce = $this->stats->getEthPrice();
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey('ethbtc', $responceDecoded['result']);
        $this->assertArrayHasKey('ethbtc_timestamp', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd_timestamp', $responceDecoded['result']);
    }

    private function getEthPriceAsyncMock(){
        $mock = $this->getMockBuilder(Stats::class)
            ->setConstructorArgs([new ApiConnector($this->apiKey), $this->prefix])
            ->setMethods(['getEthPriceAsync'])
            ->getMock();

        $responce = json_encode($this->getEthPriceAsyncResponce);
        $mock->expects($this->any())
            ->method('getEthPriceAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGetEthPriceAsync()
    {
        $responce = $this->getEthPriceAsyncMock()->getEthPriceAsync(function (){}, function (){});
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey('ethbtc', $responceDecoded['result']);
        $this->assertArrayHasKey('ethbtc_timestamp', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd', $responceDecoded['result']);
        $this->assertArrayHasKey('ethusd_timestamp', $responceDecoded['result']);

    }

    public function testGetEthSupply()
    {
        $responce = $this->stats->getEthSupply();
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $floatResult = (float)$responceDecoded['result'];

        $this->assertInternalType('float', $floatResult);
    }

    private function getEthSupplyAsyncMock(){
        $mock = $this->getMockBuilder(Stats::class)
            ->setConstructorArgs([new ApiConnector($this->apiKey), $this->prefix])
            ->setMethods(['getEthSupplyAsync'])
            ->getMock();

        $responce = json_encode($this->getEthSupplyAsyncResponce);
        $mock->expects($this->any())
            ->method('getEthSupplyAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGetEthSupplyAsync()
    {
        $responce = $this->getEthSupplyAsyncMock()->getEthSupplyAsync(function (){}, function (){});
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $floatResult = (float)$responceDecoded['result'];

        $this->assertInternalType('float', $floatResult);
    }

}