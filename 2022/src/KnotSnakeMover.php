<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

use Alex\AdventCode2022\Model\Rope;

class KnotSnakeMover
{

    private Rope $rope;


    public function __construct(int $size)
    {
        $this->rope = new Rope($size);
    }

    public function __invoke(array $moves): int
    {

        foreach($moves as $move) {
            [$direction, $step] = $move;
            $this->rope->move($direction, $step);
        }

        return count($this->rope->getTailPositionRecords());
    }
}