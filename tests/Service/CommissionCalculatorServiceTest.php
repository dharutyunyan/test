<?php

namespace Service;

use PHPUnit\Framework\TestCase;
use Test\Enum\CurrencyEnum;
use Test\Service\Client\BinApiClientInterface;
use Test\Service\Client\ExchangeRateApiClientInterface;
use Test\Service\Client\Response\BinApiResponse;
use Test\Service\Client\Response\BinApiResponseInterface;
use Test\Service\Client\Response\ExchangeRateApiResponse;
use Test\Service\Client\Response\ExchangeRateApiResponseInterface;
use Test\Service\CommissionCalculatorService;
use Test\Service\FileParserService;
use PHPUnit\Framework\Attributes\DataProvider;

class CommissionCalculatorServiceTest extends TestCase
{
    #[DataProvider('transactionProvider')]
    public function testGetTransactions(
        array $transactions,
        BinApiResponseInterface $binResponse,
        ExchangeRateApiResponseInterface $ratesResponse,
        float $expectedCommission,
    ): void {
        $fileParser = $this->createMock(FileParserService::class);
        $fileParser->method('readFile')->willReturn('');
        $fileParser->method('getRows')->willReturn($transactions);

        $binClient = $this->createMock(BinApiClientInterface::class);

        $binClient->method('getBin')->willReturn($binResponse);

        $exchangeApi = $this->createMock(ExchangeRateApiClientInterface::class);

        $exchangeApi->method('getRates')->willReturn($ratesResponse);


        $commissionCalculatorService = new CommissionCalculatorService(
            $fileParser,
            $binClient,
            $exchangeApi
        );

        $transactions = $commissionCalculatorService->getTransactions('test.file');

        $this->assertCount(1, $transactions);

        $commissionResult = $commissionCalculatorService->calculateCommissionFromFile('test.file');
        $commission = $commissionResult['commissions'][0];
        $this->assertEquals($commission, $expectedCommission);
    }

    public static function transactionProvider(): array
    {
        return [
            [
                'transactions' => [
                    ['bin' => '12345', 'amount' => 15, 'currency' => CurrencyEnum::EUR->value],
                ],
                'binResponse' => new BinApiResponse(
                    ['country' => ['alpha2' => 'DE']]
                ),
                'ratesResponse' => new ExchangeRateApiResponse(
                    [CurrencyEnum::EUR->value => 0, CurrencyEnum::USD->value => 0.8, CurrencyEnum::GBP->value => 1.3]
                ),
                'expectedCommission' => 0.15
            ],
            [
                'transactions' => [
                    ['bin' => '22222', 'amount' => 24, 'currency' => CurrencyEnum::USD->value],
                ],
                'binResponse' => new BinApiResponse(
                    ['country' => ['alpha2' => 'DE']]
                ),
                'ratesResponse' => new ExchangeRateApiResponse(
                    [CurrencyEnum::EUR->value => 0, CurrencyEnum::USD->value => 0.8, CurrencyEnum::GBP->value => 1.3]
                ),
                'expectedCommission' => 0.30
            ],
        ];
    }
}