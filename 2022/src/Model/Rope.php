<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Model;

class Rope
{
    private Knot $head;
    private array $body = [];
    private array $knotIndex = [];
    private string $originalCoordinate;

    public function __construct(int $size, int $x =0, int $y =0)
    {
        if ($size < 2) {
            throw new \Exception();
        }
        $this->head = new Knot(name: "H", x: $x, y: $y);
        for($i = 1; $i < $size; $i ++) {
            $this->body[] = new Knot(name: (string)$i, x: $x, y: $y);
        }
        $this->originalCoordinate = $x . '-' . $y;
    }

    public function getTailPositionRecords(): array
    {
        /** @var Knot $tail */
        $tail = $this->body[count($this->body) - 1] ?? null;
        if ($tail === null) {
            throw new \Exception('tail not found');
        }
        return $tail->getPositionRecords();
    }

    public function move(string $direction, int $step): void
    {
        // R move Right
        if ($direction === 'R') {
            for ($i = 0; $i < $step; $i ++) {
                $this->moveRight();
            }
        }

        // L move Left
        if ($direction === 'L') {
            for ($i = 0; $i < $step; $i ++) {
                $this->moveLeft();
            }
        }

        // U move Up
        if ($direction === 'U') {
            for ($i = 0; $i < $step; $i ++) {
                $this->moveUp();
            }
        }

        // D move Down
        if ($direction === 'D') {
            for ($i = 0; $i < $step; $i ++) {
                $this->moveDown();
            }
        }
    }

    public function display(int $gridLine, int $gridColumn): array
    {
        $this->buildKnotIndex();

        $grid = [];
        for($y = $gridColumn -1; $y >= 0; $y --) {
            $line = '';
            for ($x = 0; $x < $gridLine; $x ++) {
                $line .= $this->getKnot($x, $y);
            }
            $grid[] = $line;
        }
        return $grid;
    }

    private function getKnot(int $x, int $y): string
    {
        $coordinate = $x . '-' . $y;
        $knots = $this->knotIndex[$coordinate] ?? [];
        if (empty($knots)) {
            return '.';
        }

        sort($knots);
        if (in_array('H', $knots)) {
            return 'H';
        }

        return array_shift($knots);
    }

    private function buildKnotIndex(): void
    {
        $this->knotIndex = [];
        $this->knotIndex[$this->head->coordinate()][] = $this->head->getName();
        foreach($this->body as $knot) {
            $this->knotIndex[$knot->coordinate()][] = $knot->getName();
        }
        $this->knotIndex[$this->originalCoordinate][] = 's';
    }

    private function moveRight()
    {
        // move head Right
        $this->head->moveRight();
        $this->moveBody();
        // if next was left from it follow
        // if next was up from it follow
        // if next was down from it follow
    }

    private function moveLeft()
    {
        $this->head->moveLeft();
        $this->moveBody();
    }

    private function moveUp()
    {
        $this->head->moveUp();
        $this->moveBody();
    }

    private function moveDown()
    {
        $this->head->moveDown();
        $this->moveBody();
    }

    private function moveBody()
    {
        reset($this->body);
        $head = $this->head;

        /** @var Knot $knot */
        $knotPosition = 1;
        while(($knot = current($this->body)) !== false) {
            $knot->moveTowards($head);

            $head = $knot;
            next($this->body);
            $knotPosition ++;
        }
    }
}