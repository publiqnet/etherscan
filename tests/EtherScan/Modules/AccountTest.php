<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    private $apiKey = 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';
    private $prefix = 'api.';
    private $conn;
    private $account;
    private $address = '0xbb9bc244d798123fde783fcc1c72d3bb8c189413';
    private $getBalanceAsyncResponce = [
        'status' => 1,
        'message' => 'OK',
        'result' => '29336202160022049953',
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector($this->apiKey);
        $this->account = new Account($this->conn, $this->prefix);
    }

    public function testGetBalance()
    {
        $responce = $this->account->getBalance($this->address);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $floatResult = (float)$responceDecoded['result'];

        $this->assertInternalType('float', $floatResult);
    }

    public function testGetBalances()
    {
        $responce = $this->account->getBalances([$this->address]);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey(0, $responceDecoded['result']);
        $this->assertArrayHasKey('account', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('balance', $responceDecoded['result'][0]);
    }

    public function testGetTransactions()
    {
        $responce = $this->account->getTransactions($this->address, 1, 25, Account::SORT_ASC);
        $this->assertJson($responce);
        $responceDecoded = json_decode($responce, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey(0, $responceDecoded['result']);
        $this->assertArrayHasKey('blockNumber', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('timeStamp', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('hash', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('nonce', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('blockHash', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('transactionIndex', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('from', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('to', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('value', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gas', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gasPrice', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('isError', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('input', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('contractAddress', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('cumulativeGasUsed', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gasUsed', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('confirmations', $responceDecoded['result'][0]);

    }

    public function testGetTransactionsAsync(){
        $responseUrl = 'https://api.etherscan.io/api?module=account&action=txlist&address=0xbb9bc244d798123fde783fcc1c72d3bb8c189413&offset=25&page=1&sort=desc&apiKey=BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H';
        $url = $this->account->getTransactionsLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc');
        self::assertEquals($url, $responseUrl);

        $resp = null;

        $a = function ($responseOnResolve) use (&$resp) {
            $resp = $responseOnResolve;
            echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
        };
        $b = function ($responseOnResolve) use (&$resp) {
            $resp = $responseOnResolve;
            echo 'Called on error: ' . $responseOnResolve . PHP_EOL;
        };

        $etherScan = new \EtherScan\EtherScan($this->conn);

        $etherScan->callGroupAsync([[$url, $a, $b]]);

        $this->assertJson($resp);
        $responceDecoded = json_decode($resp, true);
        $this->assertArrayHasKey('status', $responceDecoded);
        $this->assertArrayHasKey('message', $responceDecoded);
        $this->assertArrayHasKey('result', $responceDecoded);

        $this->assertEquals('OK', $responceDecoded['message']);

        $this->assertTrue(is_array($responceDecoded['result']));
        $this->assertArrayHasKey(0, $responceDecoded['result']);
        $this->assertArrayHasKey('blockNumber', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('timeStamp', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('hash', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('nonce', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('blockHash', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('transactionIndex', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('from', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('to', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('value', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gas', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gasPrice', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('isError', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('input', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('contractAddress', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('cumulativeGasUsed', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('gasUsed', $responceDecoded['result'][0]);
        $this->assertArrayHasKey('confirmations', $responceDecoded['result'][0]);
    }
}