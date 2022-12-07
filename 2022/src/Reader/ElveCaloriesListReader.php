<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class ElveCaloriesListReader
{
    public function __invoke(string $inputFile): array
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return [];
        }

        $list = [];
        $elveCalories = [];
        while(($line = fgets($fp)) !== false)
        {
            $calories = (int)$line;
            if ($calories === 0) {
                $list[] = $elveCalories;
                $elveCalories = [];
                continue;
            }

            $elveCalories[] = (int)$line;
        }
        fclose($fp);

        if (count($elveCalories) > 0) {
            $list[] = $elveCalories;
        }

        return $list;
    }
}