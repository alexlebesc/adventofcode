<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class Cpu
{
    private int $clock = 0;
    private int $cpuExecutionTime = 0;
    private int $x = 1;
    private int $newX = 1;
    private array $strengths = [];

    public function __construct(private array $instructions)
    {
    }

    public function executeUntilCycle(int $cycle)
    {
        if ($this->clock >= $cycle) {
            throw new \Exception('cycle already passed');
        }
        do {
            $this->incrementClock();
            if (!$this->isInstructionRunning()) {
                $this->runNextInstruction();
            }
            $this->recordSignalStrengths();
        } while($this->clock < $cycle);
    }

    public function getCycle(): int
    {
        return $this->clock;
    }

    public function getRegisterX(): int
    {
        return $this->x;
    }

    public function getSignalStrenth(): int
    {
        return $this->x * $this->clock;
    }

    public function sumOfStrength(): int
    {
        return array_sum($this->strengths);
    }

    public function recordSignalStrengths(): void
    {
        if (in_array($this->clock, [20,60,100,140,180,220])) {
            $this->strengths[] = $this->getSignalStrenth();
        }
    }

    private function incrementClock(): void
    {
        $this->clock ++;
        $this->cpuExecutionTime = ($this->cpuExecutionTime > 0) ? $this->cpuExecutionTime - 1 : 0;
    }

    private function runNextInstruction()
    {
        $this->updateRegistry();
        $instruction = array_shift($this->instructions);
        if ($instruction === false) {
            throw new \Exception("no more instructions");
        }

        $instruction = explode(' ', $instruction); // run function
        $function = $instruction[0] ?? null;
        $parameter = $instruction[1] ?? null;

        match ($function) {
            'noop' => $this->noop(),
            'addx' => $this->addx($parameter),
        };
    }

    private function noop()
    {
        $this->cpuExecutionTime = 1;
        $this->newX = $this->x;
    }

    private function addx(string $parameter)
    {
        $this->cpuExecutionTime = 2;
        $this->newX = $this->x + (int)$parameter;
    }

    private function isInstructionRunning()
    {
        return ($this->cpuExecutionTime > 0);
    }

    private function updateRegistry()
    {
        $this->x = $this->newX;
    }
}