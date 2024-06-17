<?php

namespace Test\Service\Client;

use GuzzleHttp\Client;
use Test\Service\Client\Response\ExchangeRateApiResponse;
use Test\Service\Client\Response\ExchangeRateApiResponseInterface;

class ExchangeRateApiClient implements ExchangeRateApiClientInterface
{
    private const string API_URL = 'https://api.exchangeratesapi.io/latest';

    public function getRates(): ExchangeRateApiResponseInterface
    {
        $client = new Client();
        $response = $client->get(self::API_URL);
        $response = json_decode($response->getBody()->getContents(), true);
        return new ExchangeRateApiResponse($response['rates'] ?? null);
    }
}