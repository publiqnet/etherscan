<?php

use EtherScan\EtherScan;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../vendor/autoload.php';

$esApiConnector = new ApiConnector('your_api_key', EtherScan::MODE_API);
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats()->getEthPriceAsync(
        function ($responseOnResolve) {
            echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
        },
        function ($responseOnReject) {
            echo 'Called on resolve: ' . $responseOnReject . PHP_EOL;
        }
    );
echo "END OF FILE" . PHP_EOL;
