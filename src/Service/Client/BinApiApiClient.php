<?php

namespace Test\Service\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Test\Exception\NoBinFoundException;
use Test\Service\Client\Response\BinApiResponse;
use Test\Service\Client\Response\BinApiResponseInterface;

class BinApiApiClient implements BinApiClientInterface
{
    private const string API_URL = 'https://lookup.binlist.net/';

    /**
     * @throws NoBinFoundException
     * @throws GuzzleException
     */
    public function getBin(string $bin): BinApiResponseInterface
    {
        $client = new Client();
        $requestUrl = sprintf('%s%s', self::API_URL, $bin);
        $response = $client->get($requestUrl);
        $bin = json_decode($response->getBody()->getContents(), true);
        if (empty($bin)) {
            throw new NoBinFoundException('Not Found');
        }

        return new BinApiResponse($bin);
    }
}