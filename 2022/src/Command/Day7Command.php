<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\DataStreamBufferReader;
use Alex\AdventCode2022\DirectoryFinder;
use Alex\AdventCode2022\DirectoryToFreeupSpaceFinder;
use Alex\AdventCode2022\StartOfMessageMarkerDetector;
use Alex\AdventCode2022\StartOfPacketMarkerDetector;
use Alex\AdventCode2022\TerminalOutputReader;

class Day7Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input7.txt';

        $terminalOutputReader = new TerminalOutputReader();
        $filesystem = $terminalOutputReader($inputFile);

        $directoryFinder = new DirectoryFinder();
        $totalSize = $directoryFinder(filesystem: $filesystem, atMost: 100000);


        $this->outputResult(sprintf("Day7 result #1: %s", $totalSize));

        $directoryToFreeupSpaceFinder = new DirectoryToFreeupSpaceFinder();
        $totalSize = $directoryToFreeupSpaceFinder(
            filesystem: $filesystem,
            totalSpace: 70000000,
            updateSpace: 30000000
        );

        $this->outputResult(sprintf("Day7 result #2: %s", $totalSize));

    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}