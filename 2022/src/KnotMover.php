<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class KnotMover
{
    private array $headPosition;
    private array $tailPosition;
    private array $tailPositionRecords = [];


    public function __invoke(array $moves): int
    {
        $this->headPosition = [0,0];
        $this->tailPosition = $this->headPosition;
        $this->recordTailPosition();
        foreach($moves as $move) {
            [$direction, $step] = $move;
            $this->moveHeadKnot($direction, $step);
        }

        return count($this->tailPositionRecords);
    }

    private function moveHeadKnot(string $direction, int $step): void
    {
        // R move Right
        if ($direction === 'R') {
            for ($i = 0; $i < $step; $i ++) {
                // Move Head
                [$headX, $headY] = $this->headPosition;
                $headX += 1;
                [$tailX, $tailY] = $this->tailPosition;
                if ($this->followMove($headX, $headY, $tailX, $tailY)) {
                    // Move Tail
                    $this->tailPosition = $this->headPosition;
                    $this->recordTailPosition();
                }

                $this->headPosition = [$headX, $headY];
            }
        }

        // L move Left
        if ($direction === 'L') {
            for ($i = 0; $i < $step; $i ++) {

                // Move Head
                [$headX, $headY] = $this->headPosition;
                $headX -= 1;
                [$tailX, $tailY] = $this->tailPosition;
                if ($this->followMove($headX, $headY, $tailX, $tailY)) {
                    // Move Tail
                    $this->tailPosition = $this->headPosition;
                    $this->recordTailPosition();
                }

                $this->headPosition = [$headX, $headY];
            }
        }

        // U move Up
        if ($direction === 'U') {
            for ($i = 0; $i < $step; $i ++) {
                // Move Head
                [$headX, $headY] = $this->headPosition;
                $headY += 1;
                [$tailX, $tailY] = $this->tailPosition;
                if ($this->followMove($headX, $headY, $tailX, $tailY)) {
                    // Move Tail
                    $this->tailPosition = $this->headPosition;
                    $this->recordTailPosition();
                }

                $this->headPosition = [$headX, $headY];
            }
        }

        // D move Down
        if ($direction === 'D') {
            for ($i = 0; $i < $step; $i ++) {

                // Move Head
                [$headX, $headY] = $this->headPosition;
                $headY -= 1;
                [$tailX, $tailY] = $this->tailPosition;
                if ($this->followMove($headX, $headY, $tailX, $tailY)) {
                    // Move Tail
                    $this->tailPosition = $this->headPosition;
                    $this->recordTailPosition();
                }

                $this->headPosition = [$headX, $headY];
            }
        }
    }

    private function recordTailPosition(): void
    {
        $this->tailPositionRecords[] = implode('-',$this->tailPosition);
        $this->tailPositionRecords = array_unique($this->tailPositionRecords);
    }

    private function followMove(int $headX, int $headY, int $tailX, int $tailY): bool
    {
//        if ($this->isDiagonalMove($headX, $headY, $tailX,$tailY)) {
//            return false;
//        }

        return (abs($headX - $tailX) === 2) || (abs($headY - $tailY) === 2);
    }
}