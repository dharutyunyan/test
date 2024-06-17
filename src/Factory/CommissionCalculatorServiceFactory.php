<?php

namespace Test\Factory;

use Test\Service\Client\ClientFactory\BinApiClientFactory;
use Test\Service\Client\ClientFactory\ExchangeRateApiClientFactory;
use Test\Service\CommissionCalculatorService;
use Test\Service\FileParserService;

class CommissionCalculatorServiceFactory
{
    public static function createService(): CommissionCalculatorService
    {
        return new CommissionCalculatorService(
            fileParserService: new FileParserService(),
            binListClient: BinApiClientFactory::createBinApiClient(),
            exchangeRateApiClient: ExchangeRateApiClientFactory::createExchangeRateApiClient()
        );
    }
}