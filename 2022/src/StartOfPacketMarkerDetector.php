<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class StartOfPacketMarkerDetector
{
    protected int $markerSize = 4;

    public function __invoke(string $dataStreamBuffer): int|false
    {
        $dataStreamBufferLength = strlen($dataStreamBuffer);
        for($offset=0; $offset < $dataStreamBufferLength; $offset ++) {
            // take substring of MARKER_SIZE chars
            $dataToAnalyse = substr($dataStreamBuffer, $offset, $this->markerSize);
            // if no duplicate
            if (!self::stringHasCharDuplicate($dataToAnalyse)) {
                // then substring is the marker
                // the start of the marker is offset + MARKER_SIZE
                return $offset + $this->markerSize;
            }
        }
        return false;
    }

    private static function stringHasCharDuplicate(string $string): bool
    {
        $stringArray = str_split($string);
        $stringArrayUnique = array_unique($stringArray);

        return count($stringArray) !== count($stringArrayUnique);
    }
}