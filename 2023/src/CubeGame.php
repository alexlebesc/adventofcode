<?php

declare(strict_types=1);

namespace AdventCode2023;

class CubeGame
{
    private array $cubeSet;

    public function __construct()
    {
        $this->cubeSet = [
            12, // red
            14, // blue
            13, // green
        ];
    }

    public static function sumOfPossibleGame(array $given): int
    {
        $cubeGame = new CubeGame();
        $result = 0;

        $games = array_map(function($gameString) {
            [$game,$subsets] = explode(':', $gameString);
            $gameId = filter_var($game, FILTER_SANITIZE_NUMBER_INT);

            $subSets = explode(';', $subsets);

            $subSets = array_map(
                function($subSet) {
                    $colors = explode(',', $subSet);
                    $red = 0;
                    $blue = 0;
                    $green = 0;

                    foreach ($colors as $color) {
                        if (str_contains($color, 'red')) {
                            $red += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }

                        if (str_contains($color, 'blue')) {
                            $blue += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }

                        if (str_contains($color, 'green')) {
                            $green += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }
                    }

                    return [$red, $blue, $green];
                },
                $subSets
            );

            return [$gameId, $subSets];
        }, $given);

        foreach($games as [$gameId, $subSets]) {
            if ($cubeGame->isGamePossible($subSets)) {
                $result += $gameId;
            }
        }

        return $result;
    }

    public function isGamePossible(array $subSets): bool
    {
        [$redSet, $blueSet, $greenSet] = $this->cubeSet;

        foreach($subSets as [$red, $blue, $green]) {
            if ( ($red > $redSet) || ($blue > $blueSet) || ($green > $greenSet)) {
                return false;
            }
        }

        return true;
    }

    public static function sumOfPowers(array $given)
    {
        $cubeGame = new CubeGame();
        $result = 0;

        $games = array_map(function($gameString) {
            [$game,$subsets] = explode(':', $gameString);
            $gameId = filter_var($game, FILTER_SANITIZE_NUMBER_INT);

            $subSets = explode(';', $subsets);

            $subSets = array_map(
                function($subSet) {
                    $colors = explode(',', $subSet);
                    $red = 0;
                    $blue = 0;
                    $green = 0;

                    foreach ($colors as $color) {
                        if (str_contains($color, 'red')) {
                            $red += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }

                        if (str_contains($color, 'blue')) {
                            $blue += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }

                        if (str_contains($color, 'green')) {
                            $green += filter_var($color, FILTER_SANITIZE_NUMBER_INT);
                        }
                    }

                    return [$red, $blue, $green];
                },
                $subSets
            );

            return [$gameId, $subSets];
        }, $given);

        foreach($games as [$gameId, $subSets]) {
            $result += $cubeGame->power($subSets);
        }

        return $result;
    }

    public function power(mixed $subSets): int
    {
        [$redSet, $blueSet, $greenSet] = [0, 0, 0];

        foreach($subSets as [$red, $blue, $green]) {
            if ($red > $redSet) $redSet = $red;
            if ($blue > $blueSet) $blueSet = $blue;
            if ($green > $greenSet) $greenSet = $green;
        }

        return $redSet * $blueSet * $greenSet;
    }


}