<?php

class bingoSpot {
    private int $x;
    private int $y;
    private int $number;
    private bool $seen;

    public function __construct(int $number, int $x, int $y) {
        $this->number = $number;
        $this->x = $x;
        $this->y = $y;
        $this->seen = false;
    }

    public function setSeen() {
        $this->seen = true;
    }

    public function getSeen(): bool {
        return $this->seen;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getPosition() {
        return [$this->x, $this->y];
    }
}