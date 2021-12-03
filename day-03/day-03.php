<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day03 {
    public array $data;
    public int $oxIndex = 0;
    public int $coIndex = 0;

    public function __construct() {
        $this->data = array();
        $this->loadData();
    }

    public function loadData() {
        $handle = fopen(__DIR__ . '/input', 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->data[] = trim($line);
            }

            fclose($handle);
        } else {
            echo "Can't find file";
        }

        $this->solve();
    }

    public function solve() {
        dump($this->solveChallenge1());
        dump($this->solveChallenge2($this->data));
    }

    private function solveChallenge1() {
        $strlen = strlen($this->data[0]);
        $amount = array_fill(0, $strlen, array_fill(0,2,null));
        $gamma = "";
        $epsilon ="";

        foreach ($this->data as $line) {
            for($i = 0; $i < $strlen; $i++) {
                switch ($line[$i]) {
                    case 0:
                        $amount[$i][0]++;
                        break;
                    case 1:
                        $amount[$i][1]++;
                        break;
                }
            }
        }


        foreach ($amount as $line) {
            if ($line[0] > $line[1]) {
                $gamma .= "0";
                $epsilon .= "1";
            }
            else {
                $gamma .= "1";
                $epsilon .= "0";
            }
        }

        return (bindec($gamma) * bindec($epsilon));
    }

    private function solveChallenge2($list) {
        $ox = $this->getOxygen($list);
        $co = $this->getCo2($list);

        return (bindec($ox) * bindec($co));
    }

    function getOxygen($list) {
        if (count($list) == 1 )
            return $list[0];
        return $this->getOxygen($this->getHighest($list));
    }

    private function getCo2($list)
    {
        if (count($list) == 1)
            return $list[0];
        return $this->getCo2($this->getLowest($list));
    }

    function getHighest($list) {
        $result = $this->countZeroesAndOnes($list, $this->oxIndex);
        $this->oxIndex++;

        return (count($result['zeroes']) > count($result['ones']) ? $result['zeroes'] : $result['ones']);
    }

    function getLowest($list) {
        $result = $this->countZeroesAndOnes($list, $this->coIndex);
        $this->coIndex++;

        return (count($result['zeroes']) > count($result['ones']) ? $result['ones'] : $result['zeroes']);
    }

    function countZeroesAndOnes($list, $index): array {
        $zeroes = [];
        $ones = [];
        $count = array_fill(0, 2, null);
        foreach ($list as $item) {
            switch ($item[$index]) {
                case 0:
                    $count[0]++;
                    $zeroes[] = $item;
                    break;
                case 1:
                    $count[1]++;
                    $ones[] = $item;
                    break;
            }
        }

        $result['zeroes'] = $zeroes;
        $result['ones'] = $ones;

        return $result;
    }


}

new Day03();