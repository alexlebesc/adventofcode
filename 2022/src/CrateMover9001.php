<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

class CrateMover9001
{
    public function __invoke(array $originalStacks, array $moves): string
    {
        // move crates
        foreach($moves as $move) {
            [$nbCratesToMove, $fromPosition, $toPosition] = $move;

            $fromPosition = $fromPosition - 1;
            $toPosition = $toPosition -1;

            $cratesToMove = [];
            for($i = 0; $i < $nbCratesToMove; $i++) {
                $cratesToMove[] = array_pop($originalStacks[$fromPosition]);
            }

            $cratesToMove = array_reverse($cratesToMove);
            $originalStacks[$toPosition] = array_merge($originalStacks[$toPosition], $cratesToMove);
        }

        // build message
        $message = '';
        foreach($originalStacks as $stack) {
            $lastCrate = array_pop($stack);
            $message .= $lastCrate;
        }
        return $message;
    }
}