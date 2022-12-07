<?php


use Alex\AdventCode2022\RealScoreStrategyGuide;
use Alex\AdventCode2022\ScoreStrategyGuide;
use Alex\AdventCode2022\Reader\StrategyGuideReader;
use PHPUnit\Framework\TestCase;

class Day2Test extends TestCase
{
    public function testDay2(): void
    {
        // Given strategy guide
        $strategyGuide = [
            ['A','Y'],
            ['B','X'],
            ['C','Z'],
        ];

        // When I compute the Strategy guide score
        $scoreStrategyGuide = new ScoreStrategyGuide();
        $totalScore = $scoreStrategyGuide($strategyGuide);

        // Then I should have 15 as total score
        $this->assertEquals(15, $totalScore);

        // Given strategy guide
        $strategyGuide = [
            ['A','Y'],
            ['B','X'],
            ['C','Z'],
            ['A','X'],
        ];

        // When I compute the Strategy guide score
        $scoreStrategyGuide = new ScoreStrategyGuide();
        $totalScore = $scoreStrategyGuide($strategyGuide);

        // Then I should have 15 as total score
        $this->assertEquals(19, $totalScore);
    }

    public function testRealStrategy(): void
    {
        // Given strategy guide
        $strategyGuide = [
            ['A','Y'],
            ['B','X'],
            ['C','Z'],
        ];

        // When I compute the Strategy guide score
        $realScoreStrategyGuide = new RealScoreStrategyGuide();
        $totalScore = $realScoreStrategyGuide($strategyGuide);

        // Then I should have 15 as total score
        $this->assertEquals(12, $totalScore);
    }

    public function testStrategyGuideReader() {
        // GIVEN a file as input2.txt
        $inputFile = __DIR__ . '/input2.txt';

        // WHEN calling StrategyGuideReader()
        $strategyGuideReader = new StrategyGuideReader();
        $strategyGuide = $strategyGuideReader($inputFile);

        // THEN it should return an array
        $expected = [
            ['A','Y'],
            ['B','X'],
            ['C','Z'],
        ];
        $this->assertEquals($expected, $strategyGuide);
    }
}
