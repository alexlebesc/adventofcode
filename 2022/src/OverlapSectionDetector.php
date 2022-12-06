<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class OverlapSectionDetector
{
    public function __invoke(array $elvePairs): int
    {
        $overlapAssignments = array_map(
            fn(array $assignments): bool =>
            $this->isAssignmentFullyContainsOther($assignments[0] ?? '', $assignments[1] ?? ''),
            $elvePairs);
        return count(array_filter($overlapAssignments));
    }

    private function isAssignmentFullyContainsOther(string $assignment1, string $assignment2): bool
    {
        $buildSection = function(int $start, int $end): string {
            $section = [sprintf(" %s ", $start)];
            $increment = $start + 1;
            while ($increment <=  $end) {
                $section[] = sprintf(" %s ", $increment);
                $increment ++;
            }
            return implode('-',$section);
        };

        [$start, $end] = explode('-', $assignment1);
        $section1 = $buildSection((int) $start, (int) $end);

        [$start, $end] = explode('-', $assignment2);
        $section2 = $buildSection((int) $start, (int) $end);

        return (str_contains($section1, $section2) || str_contains($section2, $section1));
    }
}