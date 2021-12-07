<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day13 {
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
                array_push($this->data, trim($line));
            }

            fclose($handle);
        } else {
            echo "Can't find file";
        }

        $this->solve();
    }

    public function solve() {
        dump($this->data);
    }
}

new Day13();