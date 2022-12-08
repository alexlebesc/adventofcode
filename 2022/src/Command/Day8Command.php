<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\TreeGridReader;
use Alex\AdventCode2022\VisibleTreeFinder;

class Day8Command extends AbstractCommand
{
    protected int $day = 8;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input8.txt';

        $reader = new TreeGridReader();
        $treeGrid = $reader($inputFile);

        $visibleTreeFinder = new VisibleTreeFinder($treeGrid);
        $result1 = $visibleTreeFinder->visibleTrees();

        $this->outputResult1($result1);
        $result2 = $visibleTreeFinder->highestScenicScore();

        $this->outputResult2($result2);
    }
}