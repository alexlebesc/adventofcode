<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\DataStreamBufferReader;
use Alex\AdventCode2022\StartOfMessageMarkerDetector;
use Alex\AdventCode2022\StartOfPacketMarkerDetector;

class Day6Command
{
    public function execute(): void
    {
        $inputFile = __DIR__ . '/input6.txt';

        $dataStreamBufferReader = new DataStreamBufferReader();
        $dataStreamBuffer = $dataStreamBufferReader($inputFile);

        $startOfPacketMarkerDetector = new StartOfPacketMarkerDetector();
        $startOfPacketMarker = $startOfPacketMarkerDetector($dataStreamBuffer);

        $this->outputResult(sprintf("Day6 result #1: %s", $startOfPacketMarker));

        $startOfMessageMarkerDetector = new StartOfMessageMarkerDetector();
        $startOfMessageMarker = $startOfMessageMarkerDetector($dataStreamBuffer);

        $this->outputResult(sprintf("Day6 result #2: %s", $startOfMessageMarker));

    }

    private function outputResult(string $output): void
    {
        echo $output . "\n";
    }
}