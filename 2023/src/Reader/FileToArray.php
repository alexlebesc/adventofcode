<?php

declare(strict_types=1);

namespace AdventCode2023\Reader;

class FileToArray
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $input = [];
        while(($line = fgets($fp)) !== false)
        {
            $input[] = $line;
        }
        fclose($fp);

        return $input;
    }
}