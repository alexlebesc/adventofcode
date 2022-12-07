<?php

use Alex\AdventCode2022\BadgeDetector;
use Alex\AdventCode2022\CommonItemDetector;
use Alex\AdventCode2022\Reader\RucksackReader;
use PHPUnit\Framework\TestCase;

class Day3Test extends TestCase
{
    public function testDay3Test()
    {
        // GIVEN
        $rucksacks = [
            "vJrwpWtwJgWrhcsFMMfFFhFp",
            "jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL",
            "PmmdzqPrVvPwwTWBwg",
            "wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn",
            "ttgJtRGJQctTZtZT",
            "CrZsJsPPZsGzwwsLwLmpwMDw",
        ];

        // WHEN
        $commonItemDetector = new CommonItemDetector();
        $commonPrioritySum = $commonItemDetector($rucksacks);
        // THEN

        $this->assertEquals(157, $commonPrioritySum);
    }

    public function testBadges(): void
    {
        // GIVEN
        $rucksacks = [
            "vJrwpWtwJgWrhcsFMMfFFhFp",
            "jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL",
            "PmmdzqPrVvPwwTWBwg",
            "wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn",
            "ttgJtRGJQctTZtZT",
            "CrZsJsPPZsGzwwsLwLmpwMDw",
        ];

        // WHEN
        $badgeDetector = new BadgeDetector();
        $badgePrioritySum = $badgeDetector($rucksacks);

        // THEN
        $this->assertEquals(70, $badgePrioritySum);
    }

    public function testRucksackReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input3.txt';

        // WHEN calling RugsackReader()
        $rucksackReader = new RucksackReader();
        $rucksacks = $rucksackReader($inputFile);

        // THEN it should return an array
        $expected = [
            "vJrwpWtwJgWrhcsFMMfFFhFp",
            "jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL",
            "PmmdzqPrVvPwwTWBwg",
            "wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn",
            "ttgJtRGJQctTZtZT",
            "CrZsJsPPZsGzwwsLwLmpwMDw",
        ];
        $this->assertEquals($expected, $rucksacks);
    }

}
