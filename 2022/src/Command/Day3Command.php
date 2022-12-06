<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\BadgeDetector;
use Alex\AdventCode2022\CommonItemDetector;
use Alex\AdventCode2022\RucksackReader;

class Day3Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input3.txt';

        $rugsackReader = new RucksackReader();
        $rucksacks = $rugsackReader($inputFile);

        $commonItemDetector = new CommonItemDetector();
        $commonPrioritySum = $commonItemDetector($rucksacks);

        $this->outputResult(sprintf("Day3 result #1: %d", $commonPrioritySum));

        $badgeDetector = new BadgeDetector();
        $badgePrioritySum = $badgeDetector($rucksacks);

        $this->outputResult(sprintf("Day3 result #2: %d", $badgePrioritySum));
    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}