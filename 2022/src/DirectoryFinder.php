<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

use Alex\AdventCode2022\Model\Directory;

class DirectoryFinder
{
    public function __invoke(Directory $filesystem, int $atMost): int
    {
        // go over all directories
        // return all directories with size under at most
        $directories = $filesystem->detectDirectoriesUnder($atMost);
        return array_sum(
            array_map(
                fn(Directory $directory) => $directory->getSize(),
                $directories
            )
        );
    }
}