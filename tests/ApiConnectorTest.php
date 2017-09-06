<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H');
define('PREFIX', 'mod_api');

class ApiConnectorTest extends TestCase
{
    public function testGetInstance(){
        $api = ApiConnector::getInstance(API_KEY, PREFIX);
        $this->assertInstanceOf( $type = get_class($api), $api);
    }

}