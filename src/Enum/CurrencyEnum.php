<?php

namespace Test\Enum;

enum CurrencyEnum: string
{
    case EUR = 'EUR';
    case USD = 'USD';
    case GBP = 'GBP';
    case JPY = 'JPY';
}