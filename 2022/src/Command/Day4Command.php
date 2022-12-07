<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\ElvePairReader;
use Alex\AdventCode2022\OverlapSectionDetector;
use Alex\AdventCode2022\RealOverlapSectionDetector;

class Day4Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input4.txt';

        $elvePairReader = new ElvePairReader();
        $elvePairs = $elvePairReader($inputFile);

        $overlapSectionDetector = new OverlapSectionDetector();
        $totalFullyContainsSection = $overlapSectionDetector($elvePairs);

        $this->outputResult(sprintf("Day4 result #1: %d", $totalFullyContainsSection));

        $realOverlapSectionDetector = new RealOverlapSectionDetector();
        $totalOverLapping = $realOverlapSectionDetector($elvePairs);

        $this->outputResult(sprintf("Day4 result #2: %d", $totalOverLapping));
    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}