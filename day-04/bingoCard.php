<?php

require_once 'bingoSpot.php';

class bingoCard {
    private array $allNumbers;
    private bool $hasWon;

    public function __construct($id) {
        $this->hasWon = false;
        $this->allNumbers = array(array());
    }

    public function setRowNumbers(array ...$numberRow) {
        $rowIndex = 0;
        foreach ($numberRow as $row) {
            $colIndex = 0;
            foreach ($row as $item) {
                $this->allNumbers[$rowIndex][$colIndex] = new bingoSpot((int) $item);
                $colIndex++;
            }
            $rowIndex++;
        }
    }

    public function checkForBingo() {
        $hort = $this->checkHorizontal();
        $vert = $this->checkVertical();

        if ($hort || $vert) {
            $this->hasWon = true;
            return $this->getAllUnmarked();
        }
    }

    private function getAllUnmarked() {
        $unmarked = [];
        foreach ($this->allNumbers as $row) {
            foreach ($row as $item) {
                if (!$item->getSeen()) {
                    $unmarked[] = $item;
                }
            }
        }
        return $unmarked;
    }

    public function scratchNumberOnCard(int $number){
        foreach ($this->allNumbers as $row) {
            foreach ($row as $item) {
                if ($item->getNumber() === $number)
                    $item->setSeen();
            }
        }
    }

    private function checkHorizontal() {
        $horizontalCount = count($this->allNumbers[0]);
        for ($row = 0; $row < $horizontalCount; $row++) {
            if ($this->allNumbers[$row][0]->getSeen() && $this->allNumbers[$row][1]->getSeen() && $this->allNumbers[$row][2]->getSeen() && $this->allNumbers[$row][3]->getSeen() && $this->allNumbers[$row][4]->getSeen()) {
                return [$this->allNumbers[$row]];
            }
        }
        return [];
    }

    private function checkVertical() {
        $verticalCount = count($this->allNumbers);
        for($col = 0; $col < $verticalCount; $col++) {
            if ($this->allNumbers[0][$col]->getSeen() && $this->allNumbers[1][$col]->getSeen() && $this->allNumbers[2][$col]->getSeen() && $this->allNumbers[3][$col]->getSeen() && $this->allNumbers[4][$col]->getSeen()) {
                return [$this->allNumbers[0][$col], $this->allNumbers[1][$col], $this->allNumbers[2][$col], $this->allNumbers[3][$col], $this->allNumbers[4][$col]];
            }
        }
        return [];
    }

    public function hasWon(): bool {
        return $this->hasWon;
    }
}