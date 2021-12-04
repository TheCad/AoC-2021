<?php

class bingoSpot {
    private int $number;
    private bool $seen;

    public function __construct(int $number) {
        $this->number = $number;
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
}