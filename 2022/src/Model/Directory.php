<?php

declare(strict_types=1);

namespace Alex\AdventCode2022\Model;

use PhpParser\Node\Scalar\MagicConst\Dir;

class Directory extends Ressource
{
    /** @var Ressource[] */
    private array $ressources = [];

    public function __construct(private string $name, private ?Directory $parent = null) {

    }

    public function hasDir(string $dirname): bool
    {
        foreach ($this->ressources as $ressource) {
            if ($ressource->getName() === $dirname) {
                return true;
            }
        }

        return false;
    }

    public function addDir(Directory $directory)
    {
        $this->ressources[] = $directory;
    }

    public function hasFile(string $filename)
    {
        foreach ($this->ressources as $ressource) {
            if ($ressource->getName() === $filename) {
                return true;
            }
        }

        return false;
    }

    public function addFile(File $file)
    {
        $this->ressources[] = $file;
    }

    public function getDir(string $dirname): Directory
    {
        foreach ($this->ressources as $ressource) {
            if ($ressource->getName() === $dirname) {
                return $ressource;
            }
        }

        throw new \Exception("no directory found");
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?Directory
    {
        return $this->parent;
    }

    public function toArray(): array
    {
        $ressources = [];
        foreach($this->ressources as $ressource) {
            if ($ressource instanceof Directory) {
                $ressources += $ressource->toArray();
            }

            if ($ressource instanceof File) {
                $ressources[] = $ressource->getName();
            }
        }
        return [
            $this->getName() => $ressources
        ];
    }

    public function detectDirectoriesUnder(int $atMost): array
    {
        $directories = array_filter(
            $this->ressources,
            fn(Ressource $ressource): bool => ($ressource instanceof Directory && $ressource->getSize() < $atMost)
        );

        foreach($this->ressources as $ressource) {
            if ($ressource instanceof Directory) {
                $directories = array_merge($directories, $ressource->detectDirectoriesUnder($atMost));
            }
        }

        return $directories;
    }

    public function getSize(): int
    {
        $size = 0;
        foreach($this->ressources as $ressource) {
            $size += $ressource->getSize();
        }

        return $size;
    }

    public function detectDirectoriesAbove(int $requiredSpace)
    {
        $directories = array_filter(
            $this->ressources,
            fn(Ressource $ressource): bool => ($ressource instanceof Directory && $ressource->getSize() > $requiredSpace)
        );

        foreach($this->ressources as $ressource) {
            if ($ressource instanceof Directory) {
                $directories = array_merge($directories, $ressource->detectDirectoriesAbove($requiredSpace));
            }
        }

        return $directories;
    }
}