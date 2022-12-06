<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\ElveCaloriesListReader;
use Alex\AdventCode2022\MostCaloriesFinder;
use Alex\AdventCode2022\Top3CaloriesFinder;

class Day1Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input1.txt';

        // WHEN calling ElveCaloriesListReader()
        $elveCaloriesListReader = new ElveCaloriesListReader();
        $elveCaloriesList = $elveCaloriesListReader($inputFile);

        $mostCalorieFinder = new MostCaloriesFinder();
        $mostCalories = $mostCalorieFinder($elveCaloriesList);

        $top3CaloriesFinder = new Top3CaloriesFinder();
        $top3Calories = $top3CaloriesFinder($elveCaloriesList);

        $this->outputResult(sprintf("most calories: %d", $mostCalories));
        $this->outputResult(sprintf("top 3 calories: %d", $top3Calories));
    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}