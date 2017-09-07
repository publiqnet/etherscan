<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EtherScan\Resources\ApiConnector;
use PHPUnit\Framework\TestCase;

define('API_KEY', 'BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H');
define('PREFIX', 'mod_api');

class ApiConnectorTest extends TestCase
{
    private $conn;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->conn = new ApiConnector(API_KEY, PREFIX);
    }

}