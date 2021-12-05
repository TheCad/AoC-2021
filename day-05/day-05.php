<?php
require(__DIR__ . '/../vendor/autoload.php');

class Day05 {
    public array $data = array();
    public array $grid = array(array());
    public array $goodData = array();

    public function __construct() {
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
        $this->parseInput();
        $this->grid = array();
        $total = 0;
        foreach ($this->goodData as $coord) {
            if ($coord['dest']['x'] === $coord['origin']['x']) {
                $x = $coord['dest']['x'];
                $steps = $this->getStepsForStraightLine($coord['origin'], $coord['dest']);

                foreach ($steps as $y) {
                    if (empty($this->grid[$x][$y]))
                        $this->grid[$x][$y] = 1;
                    else
                        $this->grid[$x][$y]++;
                }
            } else {
                $y = $coord['dest']['y'];
                $steps = $this->getStepsForStraightLine($coord['origin'], $coord['dest']);

                foreach($steps as $x) {
                    if (empty($this->grid[$x][$y]))
                        $this->grid[$x][$y] = 1;
                    else
                        $this->grid[$x][$y]++;
                }
            }
        }

        unset($this->grid[0]);
        foreach ($this->grid as $item) {
            foreach ($item as $value) {
                if ($value > 1) $total++;
            }
        }

        return $total;
    }

    private function getStepsForStraightLine($origin, $destination) {
        if ($origin['x'] === $destination['x']){
            $direction = 'y';
        } else {
            $direction = 'x';
        }
        $distance = ($origin[$direction] < $destination[$direction]) ? ($destination[$direction] - $origin[$direction]) : ($origin[$direction] - $destination[$direction]);
        $start = ($origin[$direction] < $destination[$direction]) ? $origin[$direction] : $destination[$direction];
        return range($start, ($start + $distance), 1);

    }

    private function solveChallenge2() {
        $this->parseSecondInput();
        $this->grid = array();
        $total = 0;
        foreach ($this->goodData as $coord) {
            $x = (int)$coord['origin']['x'];
            $y = (int)$coord['origin']['y'];
            $xDest = (int)$coord['dest']['x'];
            $yDest = (int)$coord['dest']['y'];

            $xBackwards = $x > $xDest;
            $yBackwards = $y > $yDest;

            $xDistance = ($x < $xDest) ? ($xDest - $x) : ($x - $xDest);
            $yDistance = ($y < $yDest) ? ($yDest - $y) : ($y - $yDest);

            $count = ($xDistance > $yDistance) ? $xDistance : $yDistance;
            $index = 0;
            while($index < ($count+1)) {
                if (empty($this->grid[$x][$y]))
                    $this->grid[$x][$y] = 1;
                else
                    $this->grid[$x][$y]++;

                if ($x !== $xDest) {
                    if ($xBackwards) $x--;
                    else $x++;
                }

                if ($y !== $yDest) {
                    if ($yBackwards) $y--;
                    else $y++;
                }
                $index++;
            }
        }
        unset($this->grid[0]);
        foreach ($this->grid as $item) {
            foreach ($item as $value) {
                if ($value > 1) $total++;
            }
        }
        return $total;
    }

    private function parseInput(): void {
        $this->goodData = array();
        foreach($this->data as $line) {
            $position = $this->explodedInput($line);
            if ($position['origin']['x'] === $position['dest']['x'] || $position['origin']['y'] === $position['dest']['y']) {
                $this->goodData[] = $position;
            }
        }
    }

    private function parseSecondInput() {
        $this->goodData = array();
        foreach($this->data as $line) {
            $this->goodData[] = $this->explodedInput($line);
        }
    }

    /**
     * @param $line
     * @return array
     */
    private function explodedInput($line): array {
        $explodedLine = array_map('trim', explode('->', $line));
        $explodedOrigin = explode(',', $explodedLine[0]);
        $explodedDestination = explode(',', $explodedLine[1]);
        $position['origin']['x'] = $explodedOrigin[0];
        $position['origin']['y'] = $explodedOrigin[1];
        $position['dest']['x'] = $explodedDestination[0];
        $position['dest']['y'] = $explodedDestination[1];

        return $position;
    }
}

new Day05();