<?php

namespace Test\Factory;

use Test\Entity\TransactionEntity;
use Test\Enum\CurrencyEnum;

class TransactionFactory
{
    /**
     * @return TransactionEntity[]
     */
    public static function fromArray(array $transactionData): array
    {
        $transactions = [];
        foreach ($transactionData as $data) {
            $transactions[] = new TransactionEntity(
                bin: $data['bin'],
                amount: $data['amount'],
                currency: CurrencyEnum::tryFrom($data['currency']),
            );
        }
        return $transactions;
    }
}