<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class RealScoreStrategyGuide
{

    private const ROCKS = 1;
    private const PAPER = 2;
    private const SCISSORS = 3;

    private const LOOSE = 'LOOSE';
    private const DRAW = 'DRAW';
    private const WIN = 'WIN';

    private array $map;

    public function __construct() {
        $this->map = [
            'A' => self::ROCKS,
            'B' => self::PAPER,
            'C' => self::SCISSORS,
            'X' => self::LOOSE,
            'Y' => self::DRAW,
            'Z' => self::WIN,
        ];
    }

    public function __invoke(array $strategyGuide): int
    {
        $strategyGuide = array_map(
            function(array $battle): array {
                $you = $this->map[$battle[0]];
                $me = $this->shouldPlayTo($this->map[$battle[1]], $you);
                return [$you, $me];
            },
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

    private function shouldPlayTo(string $action, int $opponentPlay): int
    {
        if ($action === self::DRAW) {
            return $opponentPlay;
        }

        $loose = [
            self::SCISSORS => self::PAPER,
            self::PAPER => self::ROCKS,
            self::ROCKS => self::SCISSORS,
        ];

        $win = array_flip($loose);

        if ($action === self::LOOSE) {
            return $loose[$opponentPlay];
        }

        return $win[$opponentPlay];
    }
}