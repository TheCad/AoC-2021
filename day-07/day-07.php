<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day07 {
    public bool $example = false;
    public array $data;

    public function __construct() {
        $this->data = array();
        $this->loadData();
    }

    public function loadData() {
        $file = $this->example ? '/example' : '/input';
        $handle = fopen(__DIR__ . $file, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->data = explode(',', trim($line));
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

    public function solveChallenge1() {
        $amount = PHP_INT_MAX;
        $list = array_count_values($this->data);
        arsort($list);
        foreach ($list as $item => $value) {
            $fuel = $this->getAmountOfFuel($item);
            $amount = (array_sum($fuel) < $amount) ? array_sum($fuel) : $amount;
        }

        return $amount;
    }

    public function solveChallenge2() {
        $amount = PHP_INT_MAX;
        $res = [];

        foreach (range(0, max($this->data), 1) as $item => $value) {
            $fuel = array_sum($this->getAmountOfFuelIncremental($item));
            $res[] = $fuel;
        }
        sort($res);
        return $res[0];
    }

    public function getAmountOfFuel($horpos) {
        $temp = [];
        foreach ($this->data as $item) {
            $fuelcost = $horpos - $item;
            if ($fuelcost < 0) $fuelcost = -$fuelcost;
            $temp[] = $fuelcost;
        }
        return $temp;
    }

    public function getAmountOfFuelIncremental($horpos) {
        $temp = [];

        foreach ($this->data as $item) {
            $fuelcost = $horpos - $item;
            if ($fuelcost < 0) $fuelcost = -$fuelcost;
            $temp[] = array_sum(range(1, $fuelcost, 1));
        }
        $res = array_sum($temp);

        return $temp;
    }
}

new Day07();