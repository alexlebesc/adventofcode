<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Model;

abstract class Ressource
{
    abstract public function getName(): string;

    abstract public function getSize(): int;
}