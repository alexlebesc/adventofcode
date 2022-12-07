<?php

use Alex\AdventCode2022\Reader\ElvePairReader;
use Alex\AdventCode2022\OverlapSectionDetector;
use Alex\AdventCode2022\RealOverlapSectionDetector;
use PHPUnit\Framework\TestCase;

class Day4Test extends TestCase
{
    public function testDay4Test()
    {
        // GIVEN
        $elvePairs = [
            ["2-4","6-8"],
            ["2-3","4-5"],
            ["5-7","7-9"],
            ["2-8","3-7"],
            ["6-6","4-6"],
            ["2-6","4-8"],
        ];

        // WHEN
        $overlapSectionDetector = new OverlapSectionDetector();
        $totalFullyContainsSection = $overlapSectionDetector($elvePairs);

        // THEN
        $this->assertEquals(2, $totalFullyContainsSection);
    }

    public function testOverlappingAtAll()
    {
        // GIVEN
        $elvePairs = [
            ["2-4","6-8"],
            ["2-3","4-5"],
            ["5-7","7-9"],
            ["2-8","3-7"],
            ["6-6","4-6"],
            ["2-6","4-8"],
        ];

        // WHEN
        $realOverlapSectionDetector = new RealOverlapSectionDetector();
        $totalOverLapping = $realOverlapSectionDetector($elvePairs);

        // THEN
        $this->assertEquals(4, $totalOverLapping);
    }

    public function testElvePairReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input4.txt';

        // WHEN calling RugsackReader()
        $elvePairReader = new ElvePairReader();
        $elvePairs = $elvePairReader($inputFile);

        // THEN it should return an array
        $expected = [
            ["2-4","6-8"],
            ["2-3","4-5"],
            ["5-7","7-9"],
            ["2-8","3-7"],
            ["6-6","4-6"],
            ["2-6","4-8"],
        ];

        $this->assertEquals($expected, $elvePairs);
    }

}
