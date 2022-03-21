<?php
namespace TicTacToe;

class Referee
{
    private $moves;
    private $symbol;
    private $winner = '';
    private $win_combinations = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
    
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
    
        [1, 5, 9],
        [3, 5, 7]
    ];
    public function __construct($moves, $symbol) {
        $this->moves = $moves;
        $this->symbol = $symbol;
    }

    public function hasWinner() {
        foreach ($this->win_combinations as $combination) {
            $coord1 = $combination[0];
            $coord2 = $combination[1];
            $coord3 = $combination[2];
            if (
                @$this->moves[$coord1] === $this->symbol &&
                @$this->moves[$coord2] === $this->symbol &&
                @$this->moves[$coord3] === $this->symbol
            ) {
                $this->winner = $this->symbol;
                return true;
            }
        }

        return false;
    }

    public function getWinner() {
        return $this->winner;
    }
}