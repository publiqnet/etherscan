<?php

namespace EtherScan;

class Stats
{
    private $ch;

    public function __construct($ch)
    {
        $this->ch = $ch;
    }

    public function getEthPrice()
    {

    }

    public function getEthSupply()
    {

    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

}