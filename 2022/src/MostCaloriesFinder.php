<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

final class MostCaloriesFinder
{
    public function __invoke(array $caloriesList): int
    {
        $caloriesByElf = array_map(fn(array $calories) => array_sum($calories), $caloriesList);
        rsort($caloriesByElf);
        return array_shift($caloriesByElf) ?? 0;
    }
}