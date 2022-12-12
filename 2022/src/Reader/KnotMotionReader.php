<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class KnotMotionReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $knotMotions = [];
        while(($line = fgets($fp)) !== false)
        {
            [$move, $step] = explode(' ',trim($line));
            $knotMotions[] = [$move, (int) $step];
        }
        fclose($fp);

        return $knotMotions;
    }
}