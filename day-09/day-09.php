<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day09 {
    public bool $example = true;
    public array $data;
    public array $list;

    public function __construct() {
        $this->data = array();
        $this->list = array();
        $this->loadData();
    }

    public function loadData() {
        $file = $this->example ? '/example' : '/input';
        $handle = fopen(__DIR__ . $file, 'r');
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
        foreach ($this->data as $key => $line) {
            $this->list[$key] = str_split($line);
        }
        dump($this->solveChallenge1());
        dump($this->solveChallenge2());
    }

    private function solveChallenge1() {
        $smallest = false;
        for ($y = 0; $y < count($this->list); $y++) {
            for ($x = 0; $x < count($this->list[$y]); $x++) {
                $this->checkIsSmallest($x, $y);
            }
        }
        dd($this->list);
    }

    private function solveChallenge2() {

    }

    private function checkIsSmallest(?int $x, ?int $y) {
        $number = $this->list[$y][$x];
        $up = array_key_exists($y - 1, $this->list[$x]) ? $this->list[$x][$y-1] : null;
        $down = array_key_exists($y + 1, $this->list[$x]) ? $this->list[$x][$y+1] : null;
        $right = array_key_exists($x+1, $this->list) ? $this->list[$x + 1][$y]: null;
        $left = array_key_exists($x - 1, $this->list) ? $this->list[$x - 1][$y] : null;

        if (($up !== null && $up > $number) &&
            ($down !== null&& $down > $number) &&
            ($left !== null && $left > $number) &&
            ($right !== null && $right > $number)) {

        }

    }
}

new Day09();