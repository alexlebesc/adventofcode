<?php

declare(strict_types=1);

namespace AdventCode2023;

class CalibrationDetector
{
    private array $map;
    public function __construct(private readonly bool $v2 = false){
        $this->map = [
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5,
            'six' => 6,
            'seven' => 7,
            'eight' => 8,
            'nine' => 9,
        ];
    }
    public static function sumOfCalibration(array $given, bool $v2 = false): int
    {
        $detector = new CalibrationDetector($v2);
        $result = 0;

        foreach($given as $line) {
            $result += $detector->calibration($line);
        }

        return $result;
    }

    public function calibration(string $line): int
    {

        // FIRST DIGIT
        $text = $line;
        if ($this->isV2()) {
            $text = $this->transformWordIntoDigitFromStart($line);
        }

        $text = filter_var($text, FILTER_SANITIZE_NUMBER_INT);

        $firstDigit = $text[0];

        // LAST DIGIT
        $text = $line;
        if ($this->isV2()) {
            $text = $this->transformWordIntoDigitFromEnd($line);
        }

        $text = filter_var($text, FILTER_SANITIZE_NUMBER_INT);

        $lastDigit = $text[strlen($text) -1];

        return intval($firstDigit . $lastDigit);
    }

    private function transformWordIntoDigitFromStart(string $text): string
    {
        $dict = array_keys($this->map);
        $keys = array_map(fn($key) => '/' . $key . '/', $dict);

        $numberOfLetters = strlen($text);
        $word = '';
        $newText = $text;

        $i = 0;
        while ($i < $numberOfLetters) {
            $word .= $text[$i];

            if ($this->matchExists($word, $dict)) {
                $newWord = preg_replace($keys, array_values($this->map), strtolower($word));
                $newText = str_replace($word, $newWord, $newText);
                $word = '';
            }
            $i++;
        }

        return $newText;
    }

    private function transformWordIntoDigitFromEnd(string $text): string
    {
        $dict = array_keys($this->map);
        $keys = array_map(fn($key) => '/' . $key . '/', $dict);

        $numberOfLetters = strlen($text);
        $word = '';
        $newText = $text;

        $i = $numberOfLetters - 1;
        while ($i >= 0) {
            $word = $text[$i] . $word;

            if ($this->matchExists($word, $dict)) {
                $newWord = preg_replace($keys, array_values($this->map), strtolower($word));
                $newText = str_replace($word, $newWord, $newText);
                $word = '';
            }
            $i--;
        }

        return $newText;
    }

    private function matchExists(string $word, array $dict): bool
    {
        foreach($dict as $wordInDict) {
            if (str_contains($word, $wordInDict)) {
                return true;
            }
        }

        return false;
    }

    private function isV2(): bool
    {
        return $this->v2;
    }
}