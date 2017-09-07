<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../vendor/autoload.php';

$esApiConnector = new ApiConnector('BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H');
$etherScan = new EtherScan($esApiConnector);

//echo $etherScan->getAccount(EtherScan::PREFIX_API)->getTransactions
//('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1) . PHP_EOL;
echo $etherScan->getTxLink('0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3');
echo "END OF FILE" . PHP_EOL;
