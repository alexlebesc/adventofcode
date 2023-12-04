<?php

declare(strict_types=1);

namespace tests;

use AdventCode2023\CalibrationDetector;
use PHPUnit\Framework\TestCase;

class Day1Test extends TestCase
{
    public function testStar1()
    {
        // GIVEN
        $given = [
            '1abc2',
            'pqr3stu8vwx',
            'a1b2c3d4e5f',
            'treb7uchet',
        ];

        // WHEN calling SumOfCalibration
        $sumOfCalibration = CalibrationDetector::sumOfCalibration($given);

        // Then 142
        $this->assertEquals(142, $sumOfCalibration);
    }

    public function testStar2()
    {
        // GIVEN
        $given = [
            'two1nine',
            'eightwothree',
            'abcone2threexyz',
            'xtwone3four',
            '4nineeightseven2',
            'zoneight234',
            '7pqrstsixteen',
        ];

        // WHEN calling SumOfCalibration
        $sumOfCalibration = CalibrationDetector::sumOfCalibration($given, true);

        // Then 142
        $this->assertEquals(281, $sumOfCalibration);
    }
}
