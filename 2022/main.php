<?php

require __dir__ . "/vendor/autoload.php";

use Alex\AdventCode2022\Command\Day10Command;
use Alex\AdventCode2022\Command\Day1Command;
use Alex\AdventCode2022\Command\Day2Command;
use Alex\AdventCode2022\Command\Day3Command;
use Alex\AdventCode2022\Command\Day4Command;
use Alex\AdventCode2022\Command\Day5Command;
use Alex\AdventCode2022\Command\Day6Command;
use Alex\AdventCode2022\Command\Day7Command;
use Alex\AdventCode2022\Command\Day8Command;
use Alex\AdventCode2022\Command\Day9Command;

$day1Command = new Day1Command();
$day1Command->execute();

$day2Command = new Day2Command();
$day2Command->execute();

$day3Command = new Day3Command();
$day3Command->execute();

$day4Command = new Day4Command();
$day4Command->execute();

$day5Command = new Day5Command();
$day5Command->execute();

$day6Command = new Day6Command();
$day6Command->execute();

$day7Command = new Day7Command();
$day7Command->execute();

$day8Command = new Day8Command();
$day8Command->execute();

$day9Command = new Day9Command();
$day9Command->execute();

$day10Command = new Day10Command();
$day10Command->execute();