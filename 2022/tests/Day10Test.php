<?php

use Alex\AdventCode2022\Cpu;
use Alex\AdventCode2022\Reader\ProgramReader;
use PHPUnit\Framework\TestCase;

class Day10Test extends TestCase
{

    public function testCpuSignalStrengths(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input10.txt';

        // WHEN
        $reader = new ProgramReader();
        $instructions = $reader($inputFile);

        $cpu = new Cpu($instructions);

        // THEN
        // 20th cycle x = 21
        $cpu->executeUntilCycle(20);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength20 = $cpu->getSignalStrenth();

        $this->assertEquals(20, $cycle);
        $this->assertEquals(21, $x);
        $this->assertEquals(420, $strength20);

        // 60th cycle x = 19
        $cpu->executeUntilCycle(60);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength60 = $cpu->getSignalStrenth();

        $this->assertEquals(60, $cycle);
        $this->assertEquals(19, $x);
        $this->assertEquals(1140, $strength60);

        $cpu->executeUntilCycle(100);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength100 = $cpu->getSignalStrenth();

        $this->assertEquals(100, $cycle);
        $this->assertEquals(18, $x);
        $this->assertEquals(1800, $strength100);

        $cpu->executeUntilCycle(140);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength140 = $cpu->getSignalStrenth();

        $this->assertEquals(140, $cycle);
        $this->assertEquals(21, $x);
        $this->assertEquals(2940, $strength140);

        $cpu->executeUntilCycle(180);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength180 = $cpu->getSignalStrenth();

        $this->assertEquals(180, $cycle);
        $this->assertEquals(16, $x);
        $this->assertEquals(2880, $strength180);

        $cpu->executeUntilCycle(220);
        $cycle = $cpu->getCycle();
        $x = $cpu->getRegisterX();
        $strength220 = $cpu->getSignalStrenth();

        $this->assertEquals(220, $cycle);
        $this->assertEquals(18, $x);
        $this->assertEquals(3960, $strength220);

        // sum of the 20th, 60th, 100th, 140th, 180th, and 220th cycles
        $sumOfStrength = $cpu->sumOfStrength();
        $this->assertEquals(13140, $sumOfStrength);
    }

    public function testCRT()
    {
        // GIVEN
        $inputFile = __DIR__ . '/input10.txt';

        // WHEN
        $reader = new ProgramReader();
        $instructions = $reader($inputFile);

        $cpu = new Cpu($instructions);
        $cpu->executeUntilCycle(240);
        $crt = $cpu->getCrt();

        $expected = [
            "##..##..##..##..##..##..##..##..##..##..",
            "###...###...###...###...###...###...###.",
            "####....####....####....####....####....",
            "#####.....#####.....#####.....#####.....",
            "######......######......######......####",
            "#######.......#######.......#######.....",
        ];

        $this->assertEquals($expected, $crt);
    }
}
