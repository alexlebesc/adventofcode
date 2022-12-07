<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

abstract class AbstractCommand
{
    protected int $day;

    protected function outputResult1(string|int $result): void
    {
        $output = sprintf("Day%d result #1: %s", $this->day, $result);
        echo $output . "\n";
    }

    protected function outputResult2(string|int $result): void
    {
        $output = sprintf("Day%d result #2: %s", $this->day, $result);
        echo $output . "\n";
    }
}