<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\ElveCaloriesListReader;
use Alex\AdventCode2022\MostCaloriesFinder;
use Alex\AdventCode2022\Top3CaloriesFinder;

class Day1Command extends AbstractCommand
{
    protected int $day = 1;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input1.txt';

        $elveCaloriesListReader = new ElveCaloriesListReader();
        $elveCaloriesList = $elveCaloriesListReader($inputFile);

        $mostCalorieFinder = new MostCaloriesFinder();
        $mostCalories = $mostCalorieFinder($elveCaloriesList);

        $top3CaloriesFinder = new Top3CaloriesFinder();
        $top3Calories = $top3CaloriesFinder($elveCaloriesList);

        $this->outputResult1($mostCalories);
        $this->outputResult2($top3Calories);
    }
}