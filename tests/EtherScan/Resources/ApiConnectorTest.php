<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H');
define('PREFIX', 'api.');

class ApiConnectorTest extends TestCase
{
    private $conn;
    private $doAsyncRequestResponce = [
        'status' => 1,
        'message' => 'OK',
        'result' =>
            [
                'ethbtc' => '0.07153',
                'ethbtc_timestamp' => '1504784463',
                'ethusd' => '329.56',
                'ethusd_timestamp' => '1504784458',
            ],
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY);
    }

    public function doAsyncRequest(){
        $mock = $this->getMockBuilder(ApiConnector::class)
            ->setConstructorArgs([API_KEY])
            ->setMethods(['doRequestAsync'])
            ->getMock();

        $responce = json_encode($this->doAsyncRequestResponce);
        $mock->expects($this->any())
            ->method('doRequestAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGenerateLink()
    {
        $responceUrl = "https://api.etherscan.io/api?module=stats&action=ethprice&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H";
        $resource = 'api';
        $queryParams = ['module' => 'stats', 'action' => 'ethprice'];

        $this->assertTrue(is_string($resource), $resource);
        $this->assertTrue(is_array($queryParams), $queryParams);

        $url = $this->conn->generateLink(PREFIX, $resource, $queryParams);
        $this->assertEquals($responceUrl, $url);
    }

    public function testDoRequest()
    {
        $resource = 'api';
        $queryParams = ['module' => 'stats', 'action' => 'ethprice'];

        $responce = $this->conn->doRequest(PREFIX, $resource, $queryParams);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);

        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
    }

    public function testDoRequestAsync()
    {
        $resource = 'api';
        $queryParams = ['module' => 'stats', 'action' => 'ethprice'];
        $result = $this->doAsyncRequest()->doRequestAsync(PREFIX, $resource, $queryParams, function ($resolve){}, function ($reject){});
        $this->assertJson($result);
        $responceDecoded = json_decode($result, true);

        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);
    }
}