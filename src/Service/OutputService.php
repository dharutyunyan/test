<?php

namespace Test\Service;

class OutputService
{
    public static function output($array, $key): void
    {
        if (isset($array[$key])) {
            foreach ($array[$key] as $line) {
                echo $line . "\n";
            }
        }
    }
}