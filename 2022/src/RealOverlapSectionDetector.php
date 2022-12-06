<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class RealOverlapSectionDetector
{
    public function __invoke(array $elvePairs): int
    {
        $overlapAssignments = array_map(
            fn(array $assignments): bool =>
            $this->isAssignmentOverlapOther($assignments[0] ?? '', $assignments[1] ?? ''),
            $elvePairs);
        return count(array_filter($overlapAssignments));
    }

    private function isAssignmentOverlapOther(string $assignment1, string $assignment2): bool
    {
        $buildSection = function(int $start, int $end): array {
            $section = [$start];
            $increment = $start + 1;
            while ($increment <=  $end) {
                $section[] = $increment;
                $increment ++;
            }
            return $section;
        };

        [$start, $end] = explode('-', $assignment1);
        $section1 = $buildSection((int) $start, (int) $end);

        [$start, $end] = explode('-', $assignment2);
        $section2 = $buildSection((int) $start, (int) $end);

        return count(array_intersect($section1, $section2)) > 0;
    }
}