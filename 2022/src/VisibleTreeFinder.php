<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class VisibleTreeFinder
{
    private array $treeHeights = [];
    private int $treeLineLength = 0;
    private int $treeColumnLength = 0;
    private array $visibleTrees = [];

    public function __construct(array $treeGrid)
    {
        $this->initTreeMap($treeGrid);

        $this->treeVisibleFromTop();
        $this->treeVisibleFromRight();
        $this->treeVisibleFromBottom();
        $this->treeVisibleFromLeft();
    }

    private function initTreeMap(array $treeGrid): void
    {
        $firstLine = $treeGrid[0] ?? '';
        $this->treeLineLength = strlen($firstLine);
        $this->treeColumnLength = count($treeGrid);

        $this->treeHeights = [];
        foreach($treeGrid as $y => $treeLine) {
            $trees = str_split($treeLine);
            foreach($trees as $x => $treeHeight) {
                $treeCoordinate = sprintf("%d-%d",$x, $y);
                $this->treeHeights[$treeCoordinate] = (int)$treeHeight;
            }
        }
    }

    private function treeVisibleFromTop()
    {
        // look from y = 0
        for($x = 0; $x < $this->treeLineLength; $x ++) {
            $visibleTrees = [];
            for($y = 0; $y < $this->treeColumnLength; $y ++) {
               $this->treeVisibleFromEdge($visibleTrees, $x, $y);
            }
        }
    }

    private function treeVisibleFromEdge(array &$visibleTrees, int $x, int $y): void
    {
        $coordinate = sprintf("%d-%d",$x, $y);
        $treeHeight = $this->treeHeights[$coordinate];

        // take last height in visible tree
        // if tree height > than last height then it is visible
        $lastHeight = $visibleTrees[count($visibleTrees) - 1] ?? -1;
        if ($treeHeight > $lastHeight) {
            $visibleTrees[] = $treeHeight;

            if (!in_array($coordinate, $this->visibleTrees)) {
                $this->visibleTrees[] = $coordinate;
            }
        }
    }

    private function treeVisibleFromRight()
    {
        // look from x = TREE_LINE_LENGTH
        for($y = 0; $y < $this->treeColumnLength; $y ++) {
            $visibleTrees = [];
            for($x = ($this->treeLineLength -1); $x >= 0; $x --) {
                $this->treeVisibleFromEdge($visibleTrees, $x, $y);
            }
        }
    }

    private function treeVisibleFromBottom()
    {
        // look from y = TREE_COLUMN_LENGTH
        for($x = 0; $x < $this->treeLineLength; $x ++) {
            $visibleTrees = [];
            for($y = ($this->treeColumnLength - 1); $y >= 0; $y --) {
                $this->treeVisibleFromEdge($visibleTrees, $x, $y);
            }
        }
    }

    private function treeVisibleFromLeft()
    {
        // look from x = 0
        for($y = 0; $y < $this->treeColumnLength; $y ++) {
            $visibleTrees = [];
            for($x = 0; $x < $this->treeLineLength; $x ++) {
                $this->treeVisibleFromEdge($visibleTrees, $x, $y);
            }
        }
    }

    public function visibleTrees(): int
    {
        return count($this->visibleTrees);
    }

    public function highestScenicScore(): int
    {
        $scenicScores = array_map(
            fn(string $treeCoordinate) => $this->computeScenicScore($treeCoordinate), $this->visibleTrees
        );

        rsort($scenicScores);

        return array_shift($scenicScores) ?? 0;
    }

    public function computeScenicScore(string $treeCoordinate)
    {
        [$x, $y] = explode('-',$treeCoordinate);
        $x = (int) $x;
        $y = (int) $y;

        // scenic score UP
        $scenicScoreUp = $this->scenicScoreUp($x, $y);

        // scenic score RIGHT
        $scenicScoreRight = $this->scenicScoreRight($x, $y);

        // scenic score BOTTOM
        $scenicScoreBottom = $this->scenicScoreBottom($x, $y);

        // scenic score LEFT
        $scenicScoreLeft = $this->scenicScoreLeft($x, $y);

        return $scenicScoreUp * $scenicScoreRight * $scenicScoreBottom * $scenicScoreLeft;
    }

    private function scenicScoreUp(int $x, int $y): int
    {
        // Reduce Y until 0
        $treeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
        $scenicScore = 0;
        for ($y = $y - 1; $y >= 0; $y --) {
            $scenicScore ++;

            $nextTreeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
            if ($nextTreeHeight >= $treeHeight) {
                break;
            }
        }

        return $scenicScore;
    }

    private function scenicScoreRight(int $x, int $y): int
    {
        // Increase X until lengthLine
        $treeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
        $scenicScore = 0;
        for ($x = $x+1; $x < $this->treeLineLength; $x ++) {
            $scenicScore ++;

            $nextTreeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
            if ($nextTreeHeight >= $treeHeight) {
                break;
            }
        }

        return $scenicScore;
    }

    private function scenicScoreBottom(int $x, int $y): int
    {
        // Increase Y until lengthColumn
        $treeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
        $scenicScore = 0;
        for ($y = $y + 1; $y < $this->treeColumnLength; $y ++) {
            $scenicScore ++;

            $nextTreeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
            if ($nextTreeHeight >= $treeHeight) {
                break;
            }
        }

        return $scenicScore;
    }

    private function scenicScoreLeft(int $x, int $y): int
    {
        // Reduce X until 0
        $treeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
        $scenicScore = 0;
        for ($x = $x -1; $x >= 0; $x --) {
            $scenicScore ++;

            $nextTreeHeight = $this->treeHeights[$x.'-'.$y] ?? 0;
            if ($nextTreeHeight >= $treeHeight) {
                break;
            }
        }

        return $scenicScore;
    }
}