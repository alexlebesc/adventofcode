<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class BadgeDetector
{
    private array $priorities;

    public function __construct()
    {
        $this->priorities = [];
        $item = 'a';
        $priority = 1;

        while($item != 'aa') {
            $this->priorities[$item] = $priority;
            $priority ++;
            $item ++;
        }

        $item = 'A';
        while($item != 'AA') {
            $this->priorities[$item] = $priority;
            $priority ++;
            $item ++;
        }
    }

    public function __invoke(array $rucksacks): int
    {
        $rucksacksGroup = [];
        $group = [];
        foreach($rucksacks as $rucksack) {
            if (count($group) >= 3) {
                $rucksacksGroup[] = $group;
                $group = [];
            }

            $group[] = $rucksack;
        }

        $rucksacksGroup[] = $group;

        $badges = array_map(
            fn(array $group): string => $this->detectBadges(
            $group[0] ?? '',
            $group[1] ?? '',
            $group[2] ?? ''
            ),
            $rucksacksGroup
        );

        return array_sum(array_map(fn(string $item) => $this->priorities[$item] ?? 0, $badges));
    }

    private function detectBadges(string $rucksack1, string $rucksack2, string $rucksack3): string
    {
        $rucksack1Items = str_split($rucksack1);
        $rucksack2Items = str_split($rucksack2);
        $rucksack3Items = str_split($rucksack3);

        $badges = array_intersect($rucksack1Items,$rucksack2Items,$rucksack3Items);
        return array_shift($badges) ?? '';
    }
}