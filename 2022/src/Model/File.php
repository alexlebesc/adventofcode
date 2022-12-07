<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Model;

class File extends Ressource
{
    public function __construct(private string $name, private int $size) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}