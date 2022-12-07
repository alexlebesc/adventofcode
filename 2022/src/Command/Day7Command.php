<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\DirectoryFinder;
use Alex\AdventCode2022\DirectoryToFreeupSpaceFinder;
use Alex\AdventCode2022\Reader\TerminalOutputReader;

class Day7Command extends AbstractCommand
{
    protected int $day = 7;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input7.txt';

        $terminalOutputReader = new TerminalOutputReader();
        $filesystem = $terminalOutputReader($inputFile);

        $directoryFinder = new DirectoryFinder();
        $totalSize = $directoryFinder(filesystem: $filesystem, atMost: 100000);


        $this->outputResult1($totalSize);

        $directoryToFreeupSpaceFinder = new DirectoryToFreeupSpaceFinder();
        $totalSize = $directoryToFreeupSpaceFinder(
            filesystem: $filesystem,
            totalSpace: 70000000,
            updateSpace: 30000000
        );

        $this->outputResult2($totalSize);
    }
}