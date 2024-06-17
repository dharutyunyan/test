<?php

namespace Test\Service\Client\ClientFactory;

use Test\Service\Client\ExchangeRateApiClient;

class ExchangeRateApiClientFactory
{
    public static function createExchangeRateApiClient(): ExchangeRateApiClient
    {
        return new ExchangeRateApiClient();
    }
}