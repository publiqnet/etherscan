<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../../vendor/autoload.php';

$esApiConnector = new ApiConnector('BZ34DW4M5J6XZIQV5DWBC2MJV32V955Q1H', EtherScan::MODE_API);

$etherScan = new EtherScan($esApiConnector);

$res = $etherScan->getStats()->getEthPriceAsync(
    function($result){
        $result = json_decode($result, true);
        echo "<pre>"; print_r($result); echo "</pre>";
    },
    function($result){
        echo $result;
    }
);

echo "finish".PHP_EOL;
