<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class TreeGridReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $treeGrid = [];
        while(($line = fgets($fp)) !== false)
        {
            $treeGrid[] = trim($line);
        }
        fclose($fp);

        return $treeGrid;
    }
}