<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Command;

use Alex\AdventCode2022\Reader\DataStreamBufferReader;
use Alex\AdventCode2022\StartOfMessageMarkerDetector;
use Alex\AdventCode2022\StartOfPacketMarkerDetector;

class Day6Command extends AbstractCommand
{
    protected int $day = 6;

    public function execute(): void
    {
        $inputFile = __DIR__ . '/input6.txt';

        $dataStreamBufferReader = new DataStreamBufferReader();
        $dataStreamBuffer = $dataStreamBufferReader($inputFile);

        $startOfPacketMarkerDetector = new StartOfPacketMarkerDetector();
        $startOfPacketMarker = $startOfPacketMarkerDetector($dataStreamBuffer);

        $this->outputResult1($startOfPacketMarker);

        $startOfMessageMarkerDetector = new StartOfMessageMarkerDetector();
        $startOfMessageMarker = $startOfMessageMarkerDetector($dataStreamBuffer);

        $this->outputResult2($startOfMessageMarker);

    }
}