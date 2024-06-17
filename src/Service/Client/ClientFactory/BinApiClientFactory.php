<?php

namespace Test\Service\Client\ClientFactory;

use Test\Service\Client\BinApiApiClient;
use Test\Service\Client\BinApiClientInterface;

class BinApiClientFactory
{
    public static function createBinApiClient(): BinApiClientInterface
    {
        return new BinApiApiClient();
    }
}