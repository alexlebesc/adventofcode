<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class RucksackReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $rugsacks = [];
        while(($line = fgets($fp)) !== false)
        {
            $line = str_replace("\n", '', $line);
            $rugsacks[] = $line;
        }
        fclose($fp);

        return $rugsacks;
    }
}