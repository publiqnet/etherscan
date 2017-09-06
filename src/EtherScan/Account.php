<?php

namespace EtherScan;

class Account
{
    private $ch;

    public function __construct($ch)
    {
        $this->ch = $ch;
    }

    public function getBalance()
    {
    }

    public function getBalances()
    {
    }

    public function getTransactions()
    {
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

}