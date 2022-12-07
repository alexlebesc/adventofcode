<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class StrategyGuideReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $strategyGuide = [];
        while(($line = fgets($fp)) !== false)
        {
            $line = str_replace("\n", '', $line);
            $battle = explode(' ', $line);
            $strategyGuide[] = $battle;
        }
        fclose($fp);

        return $strategyGuide;
    }
}