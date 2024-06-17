<?php

namespace Test\Service;
use http\Exception\RuntimeException;
use PHPUnit\TextUI\CliArguments\Exception;

class FileParserService
{
    public function readFile($file): ?string
    {
        if (file_exists($file)) {
            return file_get_contents($file);
        }

        return null;
    }

    public function getRows(string $filePath): array
    {
        $content = $this->readFile($filePath);
        if (true === is_null($content)) {
            return [];
        }

        $dataArray = explode("\n", $content);
        $rows = [];
        foreach ($dataArray as &$row) {
            $rows[] = json_decode($row, true);
        }
        return $rows;
    }
}