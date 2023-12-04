<?php

declare(strict_types=1);

namespace AdventCode2023\Command;

use AdventCode2023\CalibrationDetector;
use AdventCode2023\Reader\FileToArray;

class Day1Command extends AbstractCommand
{
    protected int $day = 1;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input1.txt';

        $input = new FileToArray();

        $sumOfCalibration1 = CalibrationDetector::sumOfCalibration($input($inputFile));
        $sumOfCalibration2 = CalibrationDetector::sumOfCalibration($input($inputFile), true);

        $this->outputResult1($sumOfCalibration1);
        $this->outputResult2($sumOfCalibration2);
    }
}