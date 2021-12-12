<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day09 {
    public bool $example = false;
    public array $data;
    public array $list;
    public array $smallest;
    public array $pos;

    public function __construct() {
        $this->data = array();
        $this->list = array();
        $this->smallest = array();
        $this->pos = array();
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
        dump("first: " . $this->solveChallenge1());
        dump("second: " . $this->solveChallenge2());
    }

    private function solveChallenge1() {
        $total = 0;
        for ($y = 0, $yMax = count($this->list); $y < $yMax; $y++) {
            for ($x = 0, $xMax = count($this->list[$y]); $x < $xMax; $x++) {
                if($this->checkIsSmallest($x, $y)) {
                    $this->smallest[] = [$y => $this->list[$y][$x]];
                    $this->pos[] = [$y, $x];
                }
            }
        }
        foreach ($this->smallest as $item) {
            $total += (1 + min($item));
        }

        return $total;
    }

    private function solveChallenge2() {
        $result = [];
        foreach ($this->pos as $key => $value) {
            $result[$key] = $this->doThing([$value], 0 , [$value]);
        }
        rsort($result);
        return $result[0] * $result[1] * $result[2];
    }

    private function doThing($neighbours, $count = 0, $neighboursToCheck = []) {
        $steps = 0;
        $newNeighbours = [];

        foreach ($neighbours as $value) {
            $y = $value[0];
            $x = $value[1];

            if (isset($this->list[$y][$x - 1])
                && $this->list[$y][$x - 1] != 9
                && !in_array([$y, $x - 1], $neighboursToCheck, false)) {
                $steps++;
                $count++;
                array_push($neighboursToCheck, [$y, $x - 1]);
                array_push($newNeighbours, [$y, $x - 1]);
            }

            if (isset($this->list[$y][$x + 1])
                && $this->list[$y][$x + 1] != 9
                && !in_array([$y, $x + 1], $neighboursToCheck, false)) {
                $steps++;
                $count++;
                array_push($neighboursToCheck, [$y, $x + 1]);
                array_push($newNeighbours, [$y, $x + 1]);
            }

            if (isset($this->list[$y - 1][$x])
                && $this->list[$y - 1][$x] != 9
                && !in_array([$y - 1, $x], $neighboursToCheck, false)) {
                $steps++;
                $count++;
                array_push($neighboursToCheck, [$y - 1, $x]);
                array_push($newNeighbours, [$y - 1, $x]);
            }

            if (isset($this->list[$y + 1][$x])
                && $this->list[$y + 1][$x] != 9
                && !in_array([$y + 1, $x], $neighboursToCheck, false)) {
                $steps++;
                $count++;
                array_push($neighboursToCheck, [$y + 1, $x]);
                array_push($newNeighbours, [$y + 1, $x]);
            }
        }
        if ($steps !== 0) {
            return $this->doThing($newNeighbours, $count, $neighboursToCheck);
        } else {
            return $count + 1;
        }
    }

    private function checkIsSmallest(?int $x, ?int $y) {
        $number = $this->list[$y][$x];
        $up = array_key_exists($x - 1, $this->list[$y]) ? $this->list[$y][$x-1] : PHP_INT_MAX;
        $down = array_key_exists($x + 1, $this->list[$y]) ? $this->list[$y][$x+1] : PHP_INT_MAX;
        $right = array_key_exists($y + 1, $this->list) ? $this->list[$y + 1][$x]: PHP_INT_MAX;
        $left = array_key_exists($y - 1, $this->list) ? $this->list[$y - 1][$x] : PHP_INT_MAX;

        if ($up > $number &&
            $down > $number &&
            $left > $number &&
            $right > $number) {
            return true;
        }
        return false;
    }
}

new Day09();