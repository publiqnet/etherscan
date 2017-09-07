<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'testKey');
define('PREFIX', 'mod_api');

class ApiConnectorTest extends TestCase
{
    public function testGetInstance(){
        $api = ApiConnector::getInstance(API_KEY, PREFIX);
        $this->assertInstanceOf( $type = get_class($api), $api);
    }

}