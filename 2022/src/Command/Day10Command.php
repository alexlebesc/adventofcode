<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Cpu;
use Alex\AdventCode2022\Reader\ProgramReader;

class Day10Command extends AbstractCommand
{
    protected int $day = 10;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input10.txt';
        $reader = new ProgramReader();
        $instructions = $reader($inputFile);

        $cpu = new Cpu($instructions);
        $cpu->executeUntilCycle(220);
        $sumOfStrength = $cpu->sumOfStrength();

        $this->outputResult1($sumOfStrength);
        $cpu = new Cpu($instructions);
        $cpu->executeUntilCycle(240);
        $crt = $cpu->getCrt();

        echo "\n\n";
        echo implode("\n", $crt);
        echo "\n\n";
    }
}