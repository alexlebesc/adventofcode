<?php

use Alex\AdventCode2022\Reader\DataStreamBufferReader;
use Alex\AdventCode2022\StartOfMessageMarkerDetector;
use Alex\AdventCode2022\StartOfPacketMarkerDetector;
use PHPUnit\Framework\TestCase;

class Day6Test extends TestCase
{
    /**
     * @param $dataStreamBuffer
     * @param $expectedStartOfPacketMarker
     *
     * @dataProvider startOfPacketMarkerProvider
     */
    public function testStartOfPacketMarker($dataStreamBuffer, $expectedStartOfPacketMarker)
    {
        // GIVEN $dataStreamBuffer

        // WHEN
        $startOfPacketMarkerDetector = new StartOfPacketMarkerDetector();
        $startOfPacketMarker = $startOfPacketMarkerDetector($dataStreamBuffer);

        // THEN
        $this->assertEquals($expectedStartOfPacketMarker, $startOfPacketMarker);
    }

    public function startOfPacketMarkerProvider()
    {
        return [
            ["mjqjpqmgbljsphdztnvjfqwrcgsmlb", 7],
            ["bvwbjplbgvbhsrlpgdmjqwftvncz", 5],
            ["nppdvjthqldpwncqszvftbrmjlhg", 6],
            ["nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg", 10],
            ["zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw", 11],
        ];
    }

    /**
     * @param $dataStreamBuffer
     * @param $expectedStartOfPacketMarker
     *
     * @dataProvider startOfMessageMarkerProvider
     */
    public function testStartOfMessageMarker($dataStreamBuffer, $expectedStartOfPacketMarker)
    {
        // GIVEN $dataStreamBuffer

        // WHEN
        $startOfMessageMarkerDetector = new StartOfMessageMarkerDetector();
        $startOfMessageMarker = $startOfMessageMarkerDetector($dataStreamBuffer);

        // THEN
        $this->assertEquals($expectedStartOfPacketMarker, $startOfMessageMarker);
    }

    public function startOfMessageMarkerProvider()
    {
        return [
            ["mjqjpqmgbljsphdztnvjfqwrcgsmlb", 19],
            ["bvwbjplbgvbhsrlpgdmjqwftvncz", 23],
            ["nppdvjthqldpwncqszvftbrmjlhg", 23],
            ["nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg", 29],
            ["zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw", 26],
        ];
    }

    public function testDataStreamBufferReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input6.txt';

        // WHEN calling StackAndMoveReader()
        $dataStreamBufferReader = new DataStreamBufferReader();
        $dataStreamBuffer = $dataStreamBufferReader($inputFile);

        $expected = "mjqjpqmgbljsphdztnvjfqwrcgsmlb";

        $this->assertEquals($expected, $dataStreamBuffer);
    }

}
