<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBCdddd2MJV32V955Q1H');
define('HASH', '0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3');

class EtherScanTest extends TestCase
{
    private $conn;
    private $etherScan;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY);
        if(isset($this->conn)){
            $this->etherScan = new EtherScan($this->conn);
        }
    }

    public function testGetTxLink()
    {
        $responceUrl = 'https://etherscan.io/tx/0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3';
        if(isset($this->etherScan)){
            $text = $this->etherScan->getTxLink(HASH);
            $this->assertEquals($responceUrl, $text);
        }

    }

    public function testgetAddressLink()
    {
        $responceUrl = 'https://etherscan.io/address/0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3';

        if(isset($this->etherScan)){
            $text = $this->etherScan->getAddressLink(HASH);
            $this->assertEquals($responceUrl, $text);
        }
    }

}