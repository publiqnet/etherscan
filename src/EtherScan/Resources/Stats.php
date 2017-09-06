<?php

namespace EtherScan\Resources;

class Stats extends AbstractHttpResource
{
    const MODULE = 'stats';

    public function getEthPrice(bool $testMode = false)
    {
        $action = 'ethprice';
        $this->apiConnector->generateLink(self::MODULE, $action, $testMode);
    }

    public function getEthSupply(bool $testMode = false)
    {
        $action = 'ethsupply';
        $this->apiConnector->generateLink(self::MODULE, $action, $testMode);
    }

}