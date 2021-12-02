<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day02 {
    public array $data;

    public function __construct() {
        $this->data = array();
        $this->loadData();
    }

    public function loadData() {
        $handle = fopen(__DIR__ . '/input', 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                array_push($this->data, trim($line));
            }

            fclose($handle);
        } else {
            echo "Can't find file";
        }

        $this->solve();
    }

    public function solve() {
        dump($this->solveChallenge1());
        dump($this->solveChallenge2());
    }

    public function solveChallenge1(): int {
        $horizontal = 0;
        $depth = 0;
        foreach ($this->data as $step) {
            $direction = explode(' ', $step)[0];
            $amount = explode(' ', $step)[1];
            switch ($direction) {
                case "forward":
                    $horizontal += $amount;
                    break;
                case "down":
                    $depth += $amount;
                    break;
                case "up":
                    $depth -= $amount;
                    break;
            }
        }
        return $horizontal * $depth;
    }

    public function solveChallenge2(): int {
        $horizontal = 0;
        $depth = 0;
        $aim = 0;
        foreach ($this->data as $step) {
            $direction = explode(' ', $step)[0];
            $amount = explode(' ', $step)[1];
            switch ($direction) {
                case "forward":
                    $horizontal += $amount;
                    $depth += ($aim * $amount);
                    break;
                case "down":
                    $aim += $amount;
                    break;
                case "up":
                    $aim -= $amount;
                    break;
            }
        }
        return $horizontal * $depth;
    }
}

new Day02();