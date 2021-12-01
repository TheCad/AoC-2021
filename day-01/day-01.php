<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day01 {
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
            dump("Can't find file");
        }

        $this->solve();
    }

    public function solve() {
        dump($this->solveChallenge1());
        dump($this->solveChallenge2());
    }

    public function solveChallenge1(): int {
        $increments = 0;
        for ($i = 0; $i < count($this->data); $i++) {
            if ($i == count($this->data) - 1)
                break;
            if ($this->data[$i+1] > $this->data[$i])
                $increments++;
        }
        return $increments;
    }

    public function solveChallenge2(): int {
        $increments = 0;
        for ($i = 0; $i < count($this->data); $i++) {
            if ($i >= count($this->data) - 3){
                break;
            }
            $sum1 = $this->data[$i] + $this->data[$i+1] + $this->data[$i+2];
            $sum2 = $this->data[$i+1] + $this->data[$i+2] + $this->data[$i+3];

            if ($sum2 > $sum1)
                $increments++;
        }

        return $increments;
    }
}

new Day01();
