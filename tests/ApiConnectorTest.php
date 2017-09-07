<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H');
define('PREFIX', 'api');

class ApiConnectorTest extends TestCase
{
    private $conn;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY, PREFIX);
    }

    public function testGenerateLink()
    {
        $responceUrl = "https://api.etherscan.io/api?module=stats&action=ethprice&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H";
        $resource = 'api';
        $queryParams = ['module' => 'stats', 'action' => 'ethprice'];

        $this->assertTrue(is_string($resource), $resource);
        $this->assertTrue(is_array($queryParams), $queryParams);

        $url = $this->conn->generateLink($resource, $queryParams);

        $this->assertEquals($responceUrl, $url);
    }

    public function testDoRequest()
    {
        $resource = 'api';
        $queryParams = ['module' => 'stats', 'action' => 'ethprice'];

        $responce = $this->conn->doRequest($resource, $queryParams);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);

        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
    }

}