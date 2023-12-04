<?php

declare(strict_types=1);

namespace AdventCode2023\Command;

use AdventCode2023\CalibrationDetector;
use AdventCode2023\CubeGame;
use AdventCode2023\Reader\FileToArray;

class Day2Command extends AbstractCommand
{
    protected int $day = 1;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input2.txt';

        $input = new FileToArray();

        $sumOfPossibleGame = CubeGame::sumOfPossibleGame($input($inputFile));
        $sumOfPower = CubeGame::sumOfPowers($input($inputFile));

        $this->outputResult1($sumOfPossibleGame);
        $this->outputResult2($sumOfPower);
    }
}