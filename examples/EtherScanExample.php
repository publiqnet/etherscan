<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../vendor/autoload.php';

$esApiConnector = new ApiConnector('BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H', EtherScan::MODE_API);
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats()->getEthPrice();