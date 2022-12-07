<?php

use Alex\AdventCode2022\CrateMover9001;
use Alex\AdventCode2022\ElvePairReader;
use Alex\AdventCode2022\CrateMover9000;
use Alex\AdventCode2022\OverlapSectionDetector;
use Alex\AdventCode2022\RealOverlapSectionDetector;
use Alex\AdventCode2022\StackAndMoveReader;
use PHPUnit\Framework\TestCase;

class Day5Test extends TestCase
{
    public function testDay5Test()
    {
        // GIVEN
        $stacksOfCrates = [
            ["Z","N"],
            ["M","C","D"],
            ["P"],
        ];

        $moves = [
            [1,2,1], // move 1 from 2 to 1
            [3,1,3], // move 3 from 1 to 3
            [2,2,1], // move 2 from 2 to 1
            [1,1,2],// move 1 from 1 to 2
        ];

        // WHEN
        $moveCrates = new CrateMover9000();
        $topOfStacksMessage = $moveCrates($stacksOfCrates, $moves);

        // THEN
        $this->assertEquals('CMZ', $topOfStacksMessage);
    }

    public function testCrateMover9001()
    {
        // GIVEN
        $stacksOfCrates = [
            ["Z","N"],
            ["M","C","D"],
            ["P"],
        ];

        $moves = [
            [1,2,1], // move 1 from 2 to 1
            [3,1,3], // move 3 from 1 to 3
            [2,2,1], // move 2 from 2 to 1
            [1,1,2],// move 1 from 1 to 2
        ];

        // WHEN
        $moveCrates = new CrateMover9001();
        $topOfStacksMessage = $moveCrates($stacksOfCrates, $moves);

        // THEN
        $this->assertEquals('MCD', $topOfStacksMessage);
    }

    public function testStacksAndMoveReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input5.txt';

        // WHEN calling StackAndMoveReader()
        $stackAndMoveReader = new StackAndMoveReader($inputFile);
        $stacks = $stackAndMoveReader->readStacks();
        $moves = $stackAndMoveReader->readMoves();

        // THEN it should return an array
        $stacksExpected = [
            ["Z","N"],
            ["M","C","D"],
            ["P"],
        ];

        $movesExpected = [
            [1,2,1], // move 1 from 2 to 1
            [3,1,3], // move 3 from 1 to 3
            [2,2,1], // move 2 from 2 to 1
            [1,1,2],// move 1 from 1 to 2
        ];

        $this->assertEquals($stacksExpected, $stacks);
        $this->assertEquals($movesExpected, $moves);
    }

}
