<?php

namespace Test\Service\Client\Response;

use Test\Enum\CountryEnum;

class BinApiResponse implements BinApiResponseInterface
{
    public function __construct(private readonly array $bin) {
    }

    public function isEu() : bool
    {
        return CountryEnum::isEu($this->bin['country']['alpha2']);
    }
}