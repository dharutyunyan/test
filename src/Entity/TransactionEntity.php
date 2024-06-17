<?php

namespace Test\Entity;

use Test\Enum\CurrencyEnum;

class TransactionEntity
{
    public function __construct(
        private readonly int $bin,
        private readonly string $amount,
        private readonly CurrencyEnum $currency,
    ){}

    public function getBin(): int
    {
        return $this->bin;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }
}