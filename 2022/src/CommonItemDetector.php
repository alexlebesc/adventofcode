<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class CommonItemDetector
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
        $commonItems = array_map(fn(string $rucksack) => $this->detectCommonItem($rucksack), $rucksacks);
        return array_sum(array_map(fn(string $item) => $this->priorities[$item] ?? 0, $commonItems));
    }

    private function detectCommonItem(string $rucksack): string
    {
        $compartmentLength = strlen($rucksack)/2;
        $compartment1 = str_split(substr($rucksack, 0, $compartmentLength));
        $compartment2 = str_split(substr($rucksack, $compartmentLength));

        $commonItems = array_intersect($compartment1,$compartment2);
        return array_shift($commonItems) ?? '';
    }
}