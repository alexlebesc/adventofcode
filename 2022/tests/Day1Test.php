<?php

use Alex\AdventCode2022\Reader\ElveCaloriesListReader;
use Alex\AdventCode2022\MostCaloriesFinder;
use Alex\AdventCode2022\Top3CaloriesFinder;
use PHPUnit\Framework\TestCase;

class Day1Test extends TestCase
{
    public function testMostCalories() {
        // GIVEN
        $caloriesList = [
            [1000,2000,3000],
            [4000],
            [5000,6000],
            [7000,8000,9000],
            [10000]
        ];

        // WHEN calling MostCaloriesFinder()
        $mostCalorieFinder = new MostCaloriesFinder();
        $mostCalories = $mostCalorieFinder($caloriesList);

        // Then 24000
        $this->assertEquals(24000, $mostCalories);
    }

    public function testTop3() {
        // GIVEN
        $caloriesList = [
            [1000,2000,3000],
            [4000],
            [5000,6000],
            [7000,8000,9000],
            [10000]
        ];

        // WHEN calling MostCaloriesFinder()
        $top3CaloriesFinder = new Top3CaloriesFinder();
        $top3Calories = $top3CaloriesFinder($caloriesList);

        // Then 24000
        $this->assertEquals(45000, $top3Calories);
    }

    public function testElveCaloriesListReader() {
        // GIVEN a file as input1.txt
        $inputFile = __DIR__ . '/input1.txt';

        // WHEN calling ElveCaloriesListReader()
        $elveCaloriesListReader = new ElveCaloriesListReader();
        $elveCaloriesList = $elveCaloriesListReader($inputFile);

        // THEN it should return an array
        $expected = [
            [1000,2000,3000],
            [4000],
            [5000,6000],
            [7000,8000,9000],
            [10000]
        ];
        $this->assertEquals($expected, $elveCaloriesList);
    }
}
