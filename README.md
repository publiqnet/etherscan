# etherscan

<p>This lib is created for connecting to etherscan.io's api using php.</p>
<p>There are 2 possible ways of using the lib:
<ul>
<li>sync

```
$esApiConnector = new ApiConnector('your_api_key', EtherScan::MODE_API);
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats()->getEthPrice() . PHP_EOL;
echo "END OF FILE" . PHP_EOL;
```

</li>
<li>async

```
$esApiConnector = new ApiConnector('your_api_key', EtherScan::MODE_API);
$etherScan = new EtherScan($esApiConnector);

echo $etherScan->getStats()->getEthPriceAsync(
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
