<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H');
define('PREFIX', 'api');

class AccountTest extends TestCase
{
    private $conn;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY, PREFIX);
    }

    public function testGetBalance()
    {

    }

    public function testGetBalanceAsync()
    {

    }

    public function testGetBalances()
    {

    }

    public function testGetBalancesAsync()
    {

    }

    public function testGetTransactions()
    {

    }

    public function testGetTransactionsAsync()
    {

    }

}