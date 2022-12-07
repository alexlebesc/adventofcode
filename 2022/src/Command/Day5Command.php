<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\CrateMover9000;
use Alex\AdventCode2022\CrateMover9001;
use Alex\AdventCode2022\Reader\StackAndMoveReader;

class Day5Command extends AbstractCommand
{
    protected int $day = 5;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input5.txt';

        $stackAndMoveReader = new StackAndMoveReader($inputFile);
        $stacks = $stackAndMoveReader->readStacks();
        $moves = $stackAndMoveReader->readMoves();

        $moveCrates = new CrateMover9000();
        $topOfStacksMessage = $moveCrates($stacks, $moves);

        $this->outputResult1($topOfStacksMessage);

        $moveCrates = new CrateMover9001();
        $topOfStacksMessage = $moveCrates($stacks, $moves);

        $this->outputResult2($topOfStacksMessage);
    }
}