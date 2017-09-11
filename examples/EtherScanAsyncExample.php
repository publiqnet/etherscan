<?php

use EtherScan\EtherScan;
use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;

require __DIR__ . '/../vendor/autoload.php';

$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);
$a = function ($responseOnResolve) {
    echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
};
$b = function ($responseOnResolve) {
    echo 'Called on error: ' . $responseOnResolve . PHP_EOL;
};
$account = $etherScan->getAccount(EtherScan::PREFIX_API);
$startT = microtime(1);

$etherScan->callGroupAsync([
    [
        $account->getTransactionsLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, Account::SORT_DESC),
        $a, $b
    ],
    [
        $account->getTransactionsLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, Account::SORT_DESC),
        $a, $b
    ],
    [
        $account->getBalanceLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413'),
        $a, $b
    ],
    [
        $account->getTransactionsLink('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, Account::SORT_DESC),
        $a, $b
    ],
]);
$endT = microtime(1);

echo "DONE IN: " . ($endT - $startT);


