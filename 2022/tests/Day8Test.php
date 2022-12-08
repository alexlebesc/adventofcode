<?php

use Alex\AdventCode2022\Reader\TreeGridReader;
use Alex\AdventCode2022\VisibleTreeFinder;
use PHPUnit\Framework\TestCase;

class Day8Test extends TestCase
{

    public function testVisibleTreeFinder()
    {
        // GIVEN
        $inputFile = __DIR__ . '/input8.txt';

        $reader = new TreeGridReader();
        $treeGrid = $reader($inputFile);

        // WHEN
        $visibleTreeFinder = new VisibleTreeFinder($treeGrid);
        $result = $visibleTreeFinder->visibleTrees();

        // THEN
        $this->assertEquals(21, $result);
    }

    public function testHighestScenicScore(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input8.txt';

        $reader = new TreeGridReader();
        $treeGrid = $reader($inputFile);

        // WHEN
        $visibleTreeFinder = new VisibleTreeFinder($treeGrid);
        $result = $visibleTreeFinder->computeScenicScore("2-3");

        // THEN
        $this->assertEquals(8, $result);
    }

    public function testTreeGridReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input8.txt';

        // WHEN calling reader
        $reader = new TreeGridReader();
        $result = $reader($inputFile);

        // THEN
        $expected = [
            30373,
            25512,
            65332,
            33549,
            35390,
        ];

        $this->assertEquals($expected, $result);
    }
}
