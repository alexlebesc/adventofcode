<?php

use Alex\AdventCode2022\DirectoryFinder;
use Alex\AdventCode2022\DirectoryToFreeupSpaceFinder;
use Alex\AdventCode2022\Reader\TerminalOutputReader;
use PHPUnit\Framework\TestCase;

class Day7Test extends TestCase
{

    public function testDirectoryFinder()
    {
        // GIVEN
        $inputFile = __DIR__ . '/input7.txt';
        $terminalOutputReader = new TerminalOutputReader();
        $filesystem = $terminalOutputReader($inputFile);

        // WHEN
        $directoryFinder = new DirectoryFinder();
        $totalSize = $directoryFinder(filesystem: $filesystem, atMost: 100000);

        // THEN
        $this->assertEquals(95437, $totalSize);
    }

    public function testTerminalOutputReader(): void
    {
        // GIVEN
        $inputFile = __DIR__ . '/input7.txt';

        // WHEN calling reader
        $terminalOutputReader = new TerminalOutputReader();
        $filesystem = $terminalOutputReader($inputFile);

        // THEN
        $expected = [
            "/ (dir)" => [
                "a (dir)" => [
                    "e (dir)" => [
                        "i (file, size=584)",
                    ],
                    "f (file, size=29116)",
                    "g (file, size=2557)",
                    "h.lst (file, size=62596)",
                ],
                "b.txt (file, size=14848514)",
                "c.dat (file, size=8504156)",
                "d (dir)" => [
                    "j (file, size=4060174)",
                    "d.log (file, size=8033020)",
                    "d.ext (file, size=5626152)",
                    "k (file, size=7214296)",
                ],
            ],
        ];

        $this->assertEquals($expected, $filesystem->toArray());
    }

    public function testDirectoryToDelete()
    {
        // GIVEN size of filesystem is 70000000
        // And update size is 30000000
        // And current size used is 48381165
        // And size unused is 21618835
        // And filesystem:
//        "/ (dir)" => [
//            "a (dir)" => [
//                "e (dir)" => [
//                    "i (file, size=584)",
//                ],
//                "f (file, size=29116)",
//                "g (file, size=2557)",
//                "h.lst (file, size=62596)",
//            ],
//            "b.txt (file, size=14848514)",
//            "c.dat (file, size=8504156)",
//            "d (dir)" => [
//                "j (file, size=4060174)",
//                "d.log (file, size=8033020)",
//                "d.ext (file, size=5626152)",
//                "k (file, size=7214296)",
//            ],
//        ],
        $inputFile = __DIR__ . '/input7.txt';
        $terminalOutputReader = new TerminalOutputReader();
        $filesystem = $terminalOutputReader($inputFile);

        // WHEN
        $directoryToFreeupSpaceFinder = new DirectoryToFreeupSpaceFinder();
        $totalSize = $directoryToFreeupSpaceFinder(
            filesystem: $filesystem,
            totalSpace: 70000000,
            updateSpace: 30000000
        );

        // THEN
        $this->assertEquals(24933642, $totalSize);
    }

}
