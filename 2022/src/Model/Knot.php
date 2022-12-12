<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Model;

class Knot
{
    private int $previousX;
    private int $previousY;
    private array $positionRecords = [];

    public function __construct(private string $name, private int $x = 0, private int $y = 0)
    {
        $this->record();
    }

    public function moveRight()
    {
        $this->x += 1;
        $this->record();
    }

    public function moveUp()
    {
        $this->y += 1;
        $this->record();
    }

    public function moveDown()
    {
        $this->y -= 1;
        $this->record();
    }

    public function moveLeft()
    {
        $this->x -= 1;
        $this->record();
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    private function record()
    {
        $this->positionRecords[] = implode('-',[$this->x, $this->y]);
        $this->positionRecords = array_unique($this->positionRecords);
    }

    public function getPositionRecords(): array
    {
        return $this->positionRecords;
    }

    public function coordinate(): string
    {
        return $this->x . '-' . $this->y;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function moveTowards(Knot $head): void
    {

        $dX = $head->getX() - $this->getX();
        $dY = $head->getY() - $this->getY();

        if ($dY > 1 && $dX == 0 ) {
            $this->y ++;
        } elseif ($dY < -1 && $dX == 0 ) {
            $this->y --;
        } elseif ($dX > 1 && $dY == 0 ) {
            $this->x ++;
        }  elseif ($dX < -1 && $dY == 0 ) {
            $this->x --;
        }  elseif ($dY > 1 && $dX > 0 ) {
            $this->x ++;
            $this->y ++;
        } elseif ($dY > 1 && $dX < 0 ) {
            $this->x --;
            $this->y ++;
        }  elseif ($dY > 1 && $dX < -1 ) {
            $this->x --;
            $this->y ++;
        } elseif ($dY < 0 && $dX > 1 ) {
            $this->x++;
            $this->y--;
        } elseif ($dY > 0 && $dX > 1 ) {
            $this->x ++;
            $this->y ++;
        } elseif ($dY > 0 && $dX < -1 ) {
            $this->x --;
            $this->y ++;
        } elseif ($dY < 0 && $dX < -1 ) {
            $this->x --;
            $this->y --;
        } elseif ($dY < -1 && $dX < 0) {
            $this->x --;
            $this->y --;
        } elseif ($dY < -1 && $dX > 0) {
            $this->x ++;
            $this->y --;
        } elseif ($dY < -1 && $dX < -1) {
            $this->x --;
            $this->y --;
        } elseif ($dY < -1 && $dX > 1) {
            $this->x ++;
            $this->y --;
        }
        $this->record();
    }
}