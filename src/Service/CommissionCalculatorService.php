<?php

namespace Test\Service;

use Test\Entity\TransactionEntity;
use Test\Enum\CurrencyEnum;
use Test\Factory\TransactionFactory;
use Test\Service\Client\BinApiClientInterface;
use Test\Service\Client\ExchangeRateApiClientInterface;

class CommissionCalculatorService
{
    public function __construct(
        private readonly FileParserService $fileParserService,
        private readonly BinApiClientInterface $binListClient,
        private readonly ExchangeRateApiClientInterface $exchangeRateApiClient,
    ){
    }

    public function calculateCommissionFromFile(string $filePath): array
    {
        /** @var TransactionEntity[] $transactions **/
        $transactions = $this->getTransactions($filePath);

        //Exchange rates API was asking Access token, so was not able to interact with real API.
        $rates = $this->exchangeRateApiClient->getRates();
        $returnData = [];
        foreach ($transactions as $transaction) {
            try {
                $currency = $transaction->getCurrency();
                $amountFixed = 0;

                if ($currency === CurrencyEnum::EUR || $rates->getRate($currency) === 0.0) {
                    $amountFixed = $transaction->getAmount();
                }
                if ($currency !== CurrencyEnum::EUR && $rates->getRate($currency) > 0) {
                    $amountFixed = $transaction->getAmount() / $rates->getRate($currency);
                }

                $amountFixed = round($amountFixed, 2);
                $isEu = $this->binListClient->getBin($transaction->getBin())->isEu();
                $returnData['commissions'][] = $amountFixed * (true === $isEu ? 0.01 : 0.02);
            } catch (\Exception $e) {
                $returnData['error'][] = $e->getMessage();
            }
        }

        return $returnData;
    }

    public function getTransactions(string $filePath): array
    {
        return TransactionFactory::fromArray($this->fileParserService->getRows($filePath));
    }
}