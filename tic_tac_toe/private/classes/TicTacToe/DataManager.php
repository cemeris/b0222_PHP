<?php
namespace TicTacToe;

class DataManager
{
    private $data = [
        'moves' => [],
        'winner' => ''
    ];
    private $symbol = 'x';
    private $file_path;
    private $max_moves_count;

    public function __construct($file_path, $max_moves_count) {
        $this->max_moves_count = $max_moves_count;
        $this->file_path = $file_path;
        if (file_exists($file_path)) {
            $content = file_get_contents($file_path);
            $data = json_decode($content, true);
            if (is_array($data) && array_key_exists('moves', $data)) {
                $this->data = $data;
            }

            $this->updateSymbol();
        }
    }

    public function getMoves() {
        return $this->data['moves'];
    }

    public function makeMove($coord) {
        if (
            count($this->data['moves']) < $this->max_moves_count &&
            !isset($this->data['moves'][$coord]) &&
            $this->data['winner'] == ''
        ) {
            $this->updateSymbol();
            $this->data['moves'][$coord] = $this->symbol;
            $this->saveData();
            return $this->symbol;
        }
        return false;
    }

    public function resetData() {
        $this->data['moves'] = [];
        $this->data['winner'] = '';
        $this->saveData();
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function setWinner($winner) {
        $this->data['winner'] = $winner;
        $this->saveData();
    }

    public function getWinner() {
        return $this->data['winner'];
    }

    private function updateSymbol() {
        $this->symbol = (count($this->data['moves']) % 2 == 0) ? 'x' : 'o';
    }

    private function saveData() {
        $content = json_encode($this->data);
        file_put_contents($this->file_path, $content);
    }
}