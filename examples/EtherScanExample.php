<?php

require_once __DIR__ . '/../vendor/autoload.php';

$etherScan = new EtherScan\EtherScan('BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H');

echo $etherScan->getStats()->getEthPrice();