<?php

require_once __DIR__ . '/vendor/autoload.php';

use Test\Factory\CommissionCalculatorServiceFactory;
use Test\Service\OutputService;

if ($argc > 1) {
    // Loop through each argument
    for ($i = 1; $i < $argc; $i++) {
        echo "Argument $i: " . $argv[$i] . "\n";
        $commissionCalculator = CommissionCalculatorServiceFactory::createService();
        $commissions = $commissionCalculator->calculateCommissionFromFile(__DIR__ . '/' . $argv[$i]);

        // Echo commissions
        OutputService::output($commissions, 'commissions');

        // Echo errors
        OutputService::output($commissions, 'error');
    }
} else {
    echo "No arguments passed.\n";
}
?>