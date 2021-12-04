<?php
require(__DIR__ . '/../vendor/autoload.php');
require_once 'bingoCard.php';

class Day04 {
    public array $bingo;
    public array $numbers;

    public array $bingoCards;

    public function __construct() {
        $this->bingo = array();
        $this->numbers = array();
        $this->loadData();
    }

    public function loadData() {
        $bingohandle = fopen(__DIR__ . '/bingocardinput', 'r');
        $numberhandle = fopen(__DIR__. '/numberinput', 'r');
        if ($bingohandle && $numberhandle) {
            while (($line = fgets($bingohandle)) !== false) {
                $this->bingo[] = trim(str_replace("  ", " ", $line));
            }
            while(($line = fgets($numberhandle)) !== false) {
                $this->numbers = explode(',', $line);
            }

            fclose($bingohandle);
        } else {
            echo "Can't find file";
        }
        $this->readInput();
        $this->solve();
    }

    public function solve() {
        dump($this->solveChallenge1());
        dump($this->solveChallenge2());
    }

    private function solveChallenge1() {
        foreach ($this->numbers as $number) {
            /** @var bingoCard $bingoCard */
            foreach ($this->bingoCards as $bingoCard) {
                $bingoCard->scratchNumberOnCard($number);
                $result = $bingoCard->checkForBingo();
                if ($result) {
                    $sum = 0;
                    foreach ($result as $item) {
                        $sum += $item->getNumber();
                    }
                    return $sum * $number;
                }
            }
        }
    }

    private function solveChallenge2() {
        foreach($this->numbers as $number) {
            /** @var bingoCard $bingoCard */
            foreach ($this->bingoCards as $bingoCard) {
                $bingoCard->scratchNumberOnCard($number);
                $bingoCard->checkForBingo();
                if ($this->getAmountOfBingo()) {
                    $sum = 0;
                    foreach ($bingoCard->checkForBingo() as $item) {
                        $sum += $item->getNumber();
                    }
                    return $sum * $number;
                }
            }
        }
    }

    private function getAmountOfBingo() {
        $notWon =[];
        foreach ($this->bingoCards as $bingoCard) {
            if (!$bingoCard->hasWon()) {
                $notWon[] = $bingoCard;
            }
        }
        return count($notWon) === 0;
    }

    private function readInput() {
        $temp = array();
        $index = 0;
        $bingoId = 0;
        foreach ($this->bingo as $line) {
            if (empty($line)) {
                $bingoCard = new BingoCard((int)$bingoId);
                $bingoCard->setRowNumbers($temp[0], $temp[1], $temp[2], $temp[3], $temp[4]);
                $this->bingoCards[] = $bingoCard;
                $index = 0;
                $temp = array();
                $bingoId++;
                continue;
            }
            $x = explode(" ", $line);
            $temp[$index] = $x;
            $index++;
        }
    }
}

new Day04();