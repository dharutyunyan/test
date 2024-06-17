<?php

namespace Test\Service\Client;

use Test\Service\Client\Response\ExchangeRateApiResponseInterface;

interface ExchangeRateApiClientInterface
{
    public function getRates(): ExchangeRateApiResponseInterface;
}