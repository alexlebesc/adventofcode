<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\BadgeDetector;
use Alex\AdventCode2022\CommonItemDetector;
use Alex\AdventCode2022\Reader\RucksackReader;

class Day3Command extends AbstractCommand
{
    protected int $day = 3;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input3.txt';

        $rugsackReader = new RucksackReader();
        $rucksacks = $rugsackReader($inputFile);

        $commonItemDetector = new CommonItemDetector();
        $commonPrioritySum = $commonItemDetector($rucksacks);

        $this->outputResult1($commonPrioritySum);

        $badgeDetector = new BadgeDetector();
        $badgePrioritySum = $badgeDetector($rucksacks);

        $this->outputResult2($badgePrioritySum);
    }
}