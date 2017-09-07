<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../vendor/autoload.php';

$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats(EtherScan::PREFIX_API)->getEthPriceAsync(
    function ($responseOnResolve) {
        echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
    },
    function ($responseOnReject) {
        echo 'Called on resolve: ' . $responseOnReject . PHP_EOL;
    }
);
echo "END OF FILE" . PHP_EOL;
