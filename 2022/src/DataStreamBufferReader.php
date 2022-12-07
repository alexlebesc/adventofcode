<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class DataStreamBufferReader
{
    public function __invoke(string $inputFile): string
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return "";
        }

        $dataStreamBuffer = "";
        while(($line = fgets($fp)) !== false)
        {
            $dataStreamBuffer .= $line;
        }
        fclose($fp);

        return $dataStreamBuffer;
    }
}