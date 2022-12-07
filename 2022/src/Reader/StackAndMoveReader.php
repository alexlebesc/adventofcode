<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Reader;

class StackAndMoveReader
{
    private string $stackContent;
    private string $moveContent;

    /**
     * @param string $inputFile
     */
    public function __construct(string $inputFile)
    {
        $this->stackContent = '';
        $this->moveContent = '';

        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            return;
        }

        while(($line = fgets($fp)) !== false && !self::isMoveDelimiter((string) $line))
        {
            $this->stackContent .= $line;
        }

        $this->moveContent .= $line;

        while(($line = fgets($fp)) !== false)
        {
            $this->moveContent .= $line;
        }

        fclose($fp);
    }

    public function readStacks(): array
    {
        $stacksContent = rtrim($this->stackContent);
        $stackContentArray = explode("\n", $stacksContent);
        $stackContentArray = array_reverse($stackContentArray);

        // init stacks
        $stacks = [];
        $stackPositionLine = trim(array_shift($stackContentArray) ?? "");
        $stackPositions = explode('  ', $stackPositionLine);
        $totalPositions = count($stackPositions);
        $position = 0;
        while($position < $totalPositions) {
            $stacks[] = [];
            $position ++;
        }

        $cratesLine = array_shift($stackContentArray);
        while($cratesLine !== null) {
            $cratesLine = str_replace(' ', '.', $cratesLine);
            $cratesLine = str_replace('].', ']*', $cratesLine);
            $cratesLine = str_replace('....', '[-]*', $cratesLine);
            $cratesLine = str_replace('[', '', $cratesLine);
            $cratesLine = str_replace(']', '', $cratesLine);
            $cratesLine = str_replace('*', '', $cratesLine);
            //$cratesLine = str_replace('.', '', $cratesLine);
            $crates = str_split($cratesLine);
            foreach($crates as $stackPosition => $crate) {
                if ($crate !== '-') {
                    $stacks[$stackPosition][] = $crate;
                }
            }
            $cratesLine = array_shift($stackContentArray);
        }

        return $stacks;
    }

    public function readMoves(): array
    {
        $moves = explode("\n", $this->moveContent);
        return array_map(
            function(string $move): array {
                $move = str_replace('move', '', $move);
                $move = str_replace('from', '', $move);
                $move = str_replace('to', '', $move);
                $move = trim($move);
                return explode('  ', $move);
            },
            $moves
        );
    }

    private static function isMoveDelimiter(string $line)
    {
        return str_contains($line, 'move');
    }
}