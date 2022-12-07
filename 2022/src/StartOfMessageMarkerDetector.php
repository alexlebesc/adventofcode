<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class StartOfMessageMarkerDetector extends StartOfPacketMarkerDetector
{
    protected int $markerSize = 14;
}