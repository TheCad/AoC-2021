<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day03 {
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

    private function solveChallenge2() {

    }
}

new Day03();