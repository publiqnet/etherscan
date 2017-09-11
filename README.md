# etherscan

<p>This lib is created for connecting to etherscan.io's api using php.</p>
<p>There are 2 possible ways of using the lib:
<ul>
<li>sync

```
$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);


$account = $etherScan->getAccount(EtherScan::PREFIX_API);
$startT = microtime(1);
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
echo $account->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1, 25, 'desc') . PHP_EOL;
$endT = microtime(1);


echo "DONE IN: " . ($endT - $startT);
```

</li>
<li>async

```
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
```

</li>
</ul>

<p>It uses the guzzlehttp/promises to allow aync calls</p>
</p>
