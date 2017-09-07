<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H');
define('PREFIX', 'api.');

class AccountTest extends TestCase
{
    private $conn;
    private $account;
    private $address = '0xbb9bc244d798123fde783fcc1c72d3bb8c189413';
    private $getBalanceAsyncResponce = [
        'status' => 1,
        'message' => 'OK',
        'result' => '29336202160022049953',
    ];
    private $getBalancesAsyncResponce = [
            'status' => '1',
            'message' => 'OK',
            'result' =>
                [
                    [
                        'account' => '0xbb9bc244d798123fde783fcc1c72d3bb8c189413',
                        'balance' => '29336202160022049953',
                    ]
                ]
    ];
    private $getTransactionsResponce = [
        'status' => 1,
        'message' => 'OK',
        'result' => [
            [
                'blockNumber' => '4248059',
                'timeStamp' => '1504787711',
                'hash' => '0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3',
                'nonce' => '4',
                'blockHash' => '0x603d46beb4080ff4e064a0dfbeee8bb63341077868f6cefcfc56df1c40639b41',
                'transactionIndex' => '26',
                'from' => '0x3311d428291f0d20aac02ae7e153c33164c70e57',
                'to' => '0xbb9bc244d798123fde783fcc1c72d3bb8c189413',
                'value' => '0',
                'gas' => '940000',
                'gasPrice' => '37585215805',
                'isError' => '0',
                'input' => '0x095ea7b3000000000000000000000000bf4ed7b27f1d666546e30d74d50d173d20bca7540000000000000000000000000000000000000000000000022661e88a139aad55',
                'contractAddress' => '',
                'cumulativeGasUsed' => '1059677',
                'gasUsed' => '45688',
                'confirmations' => '214',
            ]
        ]
    ];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY);
        $this->account = new Account($this->conn, PREFIX);
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

    public function getBalanceAsyncMock()
    {
        $mock = $this->getMockBuilder(Account::class)
            ->setConstructorArgs([new ApiConnector(API_KEY), PREFIX])
            ->setMethods(['getBalanceAsync'])
            ->getMock();

        $responce = json_encode($this->getBalanceAsyncResponce);
        $mock->expects($this->any())
            ->method('getBalanceAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGetBalanceAsync()
    {
        $responce = $this->getBalanceAsyncMock()->getBalanceAsync($this->address, function (){}, function (){});
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

    public function getBalancesAsyncMock()
    {
        $mock = $this->getMockBuilder(Account::class)
            ->setConstructorArgs([new ApiConnector(API_KEY), PREFIX])
            ->setMethods(['getBalancesAsync'])
            ->getMock();

        $responce = json_encode($this->getBalancesAsyncResponce);
        $mock->expects($this->any())
            ->method('getBalancesAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGetBalancesAsync()
    {
        $responce = $this->getBalancesAsyncMock()->getBalancesAsync([$this->address], function (){}, function (){});
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
        $responce = $this->account->getTransactions($this->address, 1);
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

    public function getTransactionsAsyncMock()
    {
        $mock = $this->getMockBuilder(Account::class)
            ->setConstructorArgs([new ApiConnector(API_KEY), PREFIX])
            ->setMethods(['getTransactionsAsync'])
            ->getMock();

        $responce = json_encode($this->getTransactionsResponce);
        $mock->expects($this->any())
            ->method('getTransactionsAsync')
            ->will($this->returnValue($responce));

        return $mock;
    }

    public function testGetTransactionsAsync()
    {
        $responce = $this->getTransactionsAsyncMock()->getTransactionsAsync($this->address,1, 25, function (){}, function (){});
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
}