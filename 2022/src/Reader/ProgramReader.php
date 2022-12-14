<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class ProgramReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $instructions = [];
        while(($line = fgets($fp)) !== false)
        {
            $line = str_replace("\n", '', $line);
            $instructions[] = $line;
        }
        fclose($fp);

        return $instructions;
    }
}