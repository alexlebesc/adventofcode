<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\ElvePairReader;
use Alex\AdventCode2022\OverlapSectionDetector;
use Alex\AdventCode2022\RealOverlapSectionDetector;

class Day4Command extends AbstractCommand
{
    protected int $day = 4;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input4.txt';

        $elvePairReader = new ElvePairReader();
        $elvePairs = $elvePairReader($inputFile);

        $overlapSectionDetector = new OverlapSectionDetector();
        $totalFullyContainsSection = $overlapSectionDetector($elvePairs);

        $this->outputResult1($totalFullyContainsSection);

        $realOverlapSectionDetector = new RealOverlapSectionDetector();
        $totalOverLapping = $realOverlapSectionDetector($elvePairs);

        $this->outputResult2($totalOverLapping);
    }
}