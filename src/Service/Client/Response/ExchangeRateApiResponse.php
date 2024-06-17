<?php

namespace Test\Service\Client\Response;

use Test\Enum\CurrencyEnum;

class ExchangeRateApiResponse implements ExchangeRateApiResponseInterface
{
    public function __construct(private readonly ?array $rates){
    }

    public function getRate(CurrencyEnum $currencyEnum): float
    {
        return (float)($this->rates[$currencyEnum->value] ?? 0);
    }
}