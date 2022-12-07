<?php

declare(strict_types=1);

namespace Alex\AdventCode2022;

use Alex\AdventCode2022\Model\Directory;
use Alex\AdventCode2022\Model\File;

class TerminalOutputReader
{
    private Directory $filesystem;
    private ?Directory $currentDirectory = null;

    public function __invoke(string $inputFile): Directory
    {
        $fp = @fopen($inputFile, 'r');

        if ($fp === false) {
            throw new \Exception('cannot read input file');
        }

        while(($line = fgets($fp)) !== false)
        {
            $line = trim($line);

            // if line start with $ cd ..
            // then current directory becomes the parent directory
            if (str_starts_with($line, '$ cd ..')) {
                $this->changeToParentDirectory();
            }

            // if line start with $ cd
            // then create directory if does not exist in filesystem
            // and current directory becomes the new created directory
            if (str_starts_with($line, '$ cd ') && !str_ends_with($line, '..')) {
                $dirname = str_replace('$ cd ', '',$line);
                $dirname = sprintf("%s (dir)", $dirname);
                $this->createDirectory($dirname);
                $this->changeToDirectory($dirname);
            }

            // if line start by dir
            // then create directory inside current directory if does not exist
            if (str_starts_with($line, 'dir ')) {
                $dirname = str_replace('dir ', '',$line);
                $dirname = sprintf("%s (dir)", $dirname);
                $this->createDirectory($dirname);
            }

            // if line do not start by $ neither dir
            // then create file in current directory (memory name)
            if (!str_starts_with($line, '$ ') && !str_starts_with($line, 'dir ')) {
                [$size, $name] = explode(' ', $line);
                $filename = sprintf("%s (file, size=%d)", $name, $size);
                $this->createFile($filename, (int) $size);
            }
        }
        fclose($fp);

        return $this->filesystem;
    }

    private function changeToParentDirectory(): void
    {
        $this->currentDirectory = $this->currentDirectory->getParent();
    }

    private function createDirectory(string $dirname): Directory
    {
        if ($this->currentDirectory === null) {
            $this->filesystem = new Directory($dirname);
            $this->currentDirectory = $this->filesystem;
            return $this->currentDirectory;
        }

        if (!$this->currentDirectory->hasDir($dirname)) {
            $directory = (new Directory($dirname, $this->currentDirectory));
            $this->currentDirectory->addDir($directory);
        }

        return $this->currentDirectory->getDir($dirname);
    }

    private function changeToDirectory(string $dirname): void
    {
        if($this->filesystem->getName() === $dirname) {
            return;
        }

        $this->currentDirectory = $this->currentDirectory->getDir($dirname);
    }

    private function createFile(string $filename, int $size): void
    {
        if ($this->currentDirectory === null) {
            throw new \Exception("Cannot create file if current directory not set");
        }

        if (!$this->currentDirectory->hasFile($filename)) {
            $this->currentDirectory->addFile((new File($filename, $size)));
        }
    }
}