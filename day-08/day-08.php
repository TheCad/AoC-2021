<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day08 {
    public bool $example = false;
    public array $data;
    public array $numbers;

    public function __construct() {
        $this->numbers = array();
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
        dump($this->solveChallenge1());
        dump($this->solveChallenge2());
    }

    private function solveChallenge1() {
        $total = 0;
        foreach ($this->data as $line) {
            $split = explode('|', $line);
            $output = explode(' ', trim($split[1]));
            foreach ($output as $item) {
                switch (strlen($item)) {
                    case 2:
                    case 3:
                    case 4:
                    case 7:
                        $total++;
                        break;
                }
            }
        }

        return $total;
    }

    /**
     *   00000000
     *  1        2
     *  1        2
     *  1        2
     *  1        2
     *   33333333
     *  4        5
     *  4        5
     *  4        5
     *  4        5
     *   66666666
     *
     * 0 = 0,1,2,4,5,6
     * 1 = 2,5
     * 2 = 0,2,3,4,6
     * 3 = 0,2,3,5,6
     * 4 = 1,2,3,5
     * 5 = 0,1,3,5,6
     * 6 = 0,1,3,4,5,6
     * 7 = 0,2,5
     * 8 = 0,1,2,3,4,5,6
     * 9 = 0,1,2,3,5,6
     */
    private function solveChallenge2() {
        $total = 0;
        foreach ($this->data as $line) {
            [$input, $output] = array_map('trim', explode("|", $line));
            $this->decodeLetters($input);
            foreach ($this->numbers as &$item) {
                $str = str_split($item);
                sort($str);
                $item = implode($str);
            }
            unset($item);
            $total += $this->getAmount($output);
        }
        return $total;
    }

    private function getAmount($letters) {
        $list = explode(' ', $letters);
        $total = '';
        foreach ($list as $value) {
            $str = str_split($value);
            sort($str);
            $value = implode($str);
            $number = array_search($value, $this->numbers, false);
            $total .= $number;
        }

        return (int)$total;
    }

    private function decodeLetters($letters) {
        $list = explode(" ", $letters);
        usort($list, function($a, $b) {
            return strlen($a) - strlen($b);
        });
        $this->setEasyNumbers($list);
        $this->checkForThree($list);
        $this->checkForNine($list);
        $this->checkForFive($list);
        $this->checkForSix($list);
        $this->checkForTwo($list);
        $this->checkForZero($list);
    }

    private function setEasyNumbers(&$array) {
        $this->numbers[1] = $array[0];
        $this->numbers[7] = $array[1];
        $this->numbers[4] = $array[2];
        $this->numbers[8] = $array[9];
        unset($array[0]); unset($array[1]); unset($array[2]); unset($array[9]);
    }

    private function checkForThree(&$array) {
        foreach ($array as $key => $value) {
            if ((str_contains($value, $this->numbers[1][0]) && str_contains($value, $this->numbers[1][1])) && strlen($value) === 5) {
                $this->numbers[3] = $value;
                unset($array[$key]);
            }
        }
    }

    private function checkForNine(&$array) {
        $three = $this->numbers[3];
        foreach ($array as $key => $value) {
            if (strlen($value) === 6) {
                $diff = array_diff(str_split($value), str_split($three));
                if (count($diff) === 1) {
                    $this->numbers[9] = $value;
                    unset($array[$key]);
                }
            }
        }
    }

    private function checkForFive(&$array) {
        $nine = str_split($this->numbers[9]);
        $three = str_split($this->numbers[3]);
        foreach($array as $key => $value) {
            $temp = array_unique(array_merge($three, str_split($value)));
            sort($nine);
            sort($temp);
            if ($nine == $temp) {
                $this->numbers[5] = $value;
                unset($array[$key]);
            }
        }
    }

    private function checkForSix(&$array) {
        $nine = str_split($this->numbers[9]);
        $five = str_split($this->numbers[5]);
        $eight = str_split($this->numbers[8]);

        $diff = array_diff($nine, $five);
        unset($eight[array_search(min($diff), $eight)]);
        sort($eight);

        foreach ($array as $key => $value) {
            $temp = str_split($value);
            sort($temp);
            if ($eight == $temp) {
                $this->numbers[6] = $value;
                unset($array[$key]);
            }
        }
    }

    private function checkForTwo(&$array) {
        $this->numbers[2] = array_shift($array);
    }

    private function checkForZero($array) {
        $this->numbers[0] = max($array);
    }
}

new Day08();