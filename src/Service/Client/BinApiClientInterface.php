<?php

namespace Test\Service\Client;

use Test\Service\Client\Response\BinApiResponseInterface;

interface BinApiClientInterface
{
    public function getBin(string $bin): BinApiResponseInterface;
}