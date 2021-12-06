<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day06 {
    public array $data;

    public function __construct() {
        $this->data = array();
        $this->loadData();
    }

    public function loadData() {
        $handle = fopen(__DIR__ . '/input', 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->data = explode(',',$line);
            }

            fclose($handle);
        } else {
            echo "Can't find file";
        }

        $this->solve();
    }

    public function solve() {
        dump($this->doSteps(18));
        dump($this->doSteps(256));
    }

    private function doSteps($count) {
        $temp = new \Ds\Deque(array_fill(0, 9, 0));

        foreach ($this->data as $value) {
            $temp[(int)$value] += 1;
        }

        foreach (range(0, $count-1) as $item) {
            $temp->rotate(1);
            $temp[6] += $temp[8];
        }
        return $temp->sum();
    }
}

new Day06();