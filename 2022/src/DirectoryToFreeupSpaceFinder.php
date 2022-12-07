<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

use Alex\AdventCode2022\Model\Directory;

class DirectoryToFreeupSpaceFinder
{
    public function __invoke(Directory $filesystem, int $totalSpace, int $updateSpace): int
    {
        $currentUnusedSpace = $totalSpace - $filesystem->getSize();

        if ($currentUnusedSpace >= $updateSpace) {
            throw new \Exception('enough space');
        }

        $requiredSpace = $updateSpace - $currentUnusedSpace;

        // go over all directories
        // return all directories with size under at most
        $directories = $filesystem->detectDirectoriesAbove($requiredSpace);

        if (count($directories) === 0) {
            throw new \Exception('no directory found to free up space');
        }

        $directorySizes =array_map(
            fn(Directory $directory) => $directory->getSize(),
            $directories
        );

        sort($directorySizes);

        return $directorySizes[0];
    }
}