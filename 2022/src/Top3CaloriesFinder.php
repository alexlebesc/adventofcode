<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class Top3CaloriesFinder
{
    public function __invoke(array $caloriesList): int
    {
        $caloriesByElf = array_map(fn(array $calories) => array_sum($calories), $caloriesList);
        rsort($caloriesByElf);
        $first = array_shift($caloriesByElf) ?? 0;
        $second = array_shift($caloriesByElf) ?? 0;
        $third = array_shift($caloriesByElf) ?? 0;

        return (int) ($first + $second + $third);
    }
}