<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class ScoreStrategyGuide
{
    private const ROCKS = 1;
    private const PAPER = 2;
    private const SCISSORS = 3;

    private array $map;

    public function __construct() {
        $this->map = [
          'A' => self::ROCKS,
          'B' => self::PAPER,
          'C' => self::SCISSORS,
          'X' => self::ROCKS,
          'Y' => self::PAPER,
          'Z' => self::SCISSORS,
        ];
    }

    public function __invoke(array $strategyGuide): int
    {
        $strategyGuide = array_map(
            fn(array $battle) => [$this->map[$battle[0]], $this->map[$battle[1]]],
            $strategyGuide
        );
        return array_sum(
            array_map(
                fn(array $battle): int => $this->battleScore($battle[0], $battle[1]),
                $strategyGuide
            )
        );
    }

    private function battleScore(int $you, int $me): int
    {
        $score = 0;
        if ($me === self::ROCKS) {
            $score += 1;
        }

        if ($me === self::PAPER) {
            $score += 2;
        }

        if ($me === self::SCISSORS) {
            $score += 3;
        }

        if ($me === $you) {
            $score += 3;
        }

        // Scissors > Paper > Rocks > Scissors
        if ($me === self::SCISSORS && $you === self::PAPER) {
            $score +=6;
        }

        if ($me === self::PAPER && $you === self::ROCKS) {
            $score +=6;
        }

        if ($me === self::ROCKS && $you === self::SCISSORS) {
            $score +=6;
        }

        return $score;
    }
}