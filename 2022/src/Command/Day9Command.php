<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\KnotMover;
use Alex\AdventCode2022\KnotSnakeMover;
use Alex\AdventCode2022\Reader\KnotMotionReader;

class Day9Command extends AbstractCommand
{
    protected int $day = 9;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input9.txt';
        $reader = new KnotMotionReader();
        $knotMoves = $reader($inputFile);

        $knotMover = new KnotMover(2);
        $result1 = $knotMover($knotMoves);

        $this->outputResult1($result1);

        $knotMover = new KnotSnakeMover(10);
        $result2 = $knotMover($knotMoves);

        $this->outputResult2($result2);
    }
}