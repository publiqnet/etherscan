# etherscan

<p>This lib is created for connecting to etherscan.io's api using php.</p>
<p>There are 2 possible ways of using the lib:
<ul>
<li>sync

```
$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getAccount(EtherScan::PREFIX_API)->getTransactions('0xbb9bc244d798123fde783fcc1c72d3bb8c189413', 1) . PHP_EOL;
echo $etherScan->getTxLink('0x14dc46124c7cc003c158eb6ba812b2f53d509753fd931607edad957504d19bd3');
echo "END OF FILE" . PHP_EOL;
```

</li>
<li>async

```
$esApiConnector = new ApiConnector('your_api_key');
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats(EtherScan::PREFIX_API)->getEthPriceAsync(
    function ($responseOnResolve) {
        echo 'Called on resolve: ' . $responseOnResolve . PHP_EOL;
    },
    function ($responseOnReject) {
        echo 'Called on reject: ' . $responseOnReject . PHP_EOL;
    }
);
echo "END OF FILE" . PHP_EOL;
```

</li>
</ul>

<p>It uses the guzzlehttp/promises to allow aync calls</p>
</p>
