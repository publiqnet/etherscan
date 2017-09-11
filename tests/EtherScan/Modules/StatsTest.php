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

    public function testGetEthPriceAsync(){
        $responseUrl = 'https://api.etherscan.io/api?module=stats&action=ethsupply&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';
        $url = $this->stats->getEthSupplyLink();
        self::assertEquals($url, $responseUrl);

        $resp = [];

        $a = function ($responseOnResolve) use (&$resp) {
            $resp[] = $responseOnResolve;
            echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
        };
        $b = function ($responseOnResolve) use (&$resp) {
            $resp[] = $responseOnResolve;
            echo 'Called on error: ' . $responseOnResolve . PHP_EOL;
        };

        $etherScan = new \EtherScan\EtherScan($this->conn);

        $etherScan->callGroupAsync([[$url, $a, $b], [$url, $a, $b]]);

        self::assertTrue(is_array($resp));
        self::assertEquals(count($resp), 2);
        self::assertJson($resp[0]);
        $responceDecoded = json_decode($resp[0], true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
        $floatResult = (float)$responceDecoded['result'];

        $this->assertInternalType('float', $floatResult);
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

}