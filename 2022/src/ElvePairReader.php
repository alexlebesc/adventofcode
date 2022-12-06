<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class ElvePairReader
{
    public function __construct()
    {
    }

    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $elvePairs = [];
        while(($line = fgets($fp)) !== false)
        {
            $line = str_replace("\n", '', $line);
            $elvePairs[] = explode(',', $line);
        }
        fclose($fp);

        return $elvePairs;
    }
}