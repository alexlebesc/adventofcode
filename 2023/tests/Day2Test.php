<?php

declare(strict_types=1);

use AdventCode2023\CubeGame;
use PHPUnit\Framework\TestCase;

class Day2Test extends TestCase
{
    public function testStar1()
    {
        // GIVEN
        $given = [
            "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
            "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
            "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
            "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
            "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green",
        ];

        // WHEN calling possibleGame
        $sumOfPossibleGame = CubeGame::sumOfPossibleGame($given);

        // Then 8
        $this->assertEquals(8, $sumOfPossibleGame);
    }

    public function testStar2()
    {
        // GIVEN
        $given = [
            "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
            "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
            "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
            "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
            "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green",
        ];

        // WHEN calling possibleGame
        $sumOfPowers = CubeGame::sumOfPowers($given);

        // Then 8
        $this->assertEquals(2286, $sumOfPowers);
    }
}
