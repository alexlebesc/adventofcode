<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\RealScoreStrategyGuide;
use Alex\AdventCode2022\ScoreStrategyGuide;
use Alex\AdventCode2022\Reader\StrategyGuideReader;

class Day2Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input2.txt';

        $strategyGuideReader = new StrategyGuideReader();
        $strategyGuide = $strategyGuideReader($inputFile);

        $scoreStrategyGuide = new ScoreStrategyGuide();
        $totalScore = $scoreStrategyGuide($strategyGuide);

        $realScoreStrategyGuide = new RealScoreStrategyGuide();
        $realRotalScore = $realScoreStrategyGuide($strategyGuide);

        $this->outputResult(sprintf("strategy guide total score: %d", $totalScore));
        $this->outputResult(sprintf("strategy guide total real score: %d", $realRotalScore));

    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}