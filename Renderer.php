<?php

class Renderer
{
      // public function __construct($field, $currentPlayer) {
      //   $this->field = $field;
      //   $this->currentPlayer = $currentPlayer;
      // }

    public function getNewTile($field, $currentPlayer) {
      $this->render($field, $currentPlayer);

      echo "Playing: " . $this->playerToStone($currentPlayer) . "\n";
      return readline("Place your stone: ");
    }

    public function invalidTile() {
      echo  "\e[1m\e[31m" .
            "INVALID PLACEMENT" . "\e[0m\e[2m" .
            " learn to play." . "\e[0m" . "\n\n";
    }

    public function drawDraw() {
      echo "It's a draw. Try again!";
    }

    public function winner($player) {
      echo "Player " . $this->playerToStone($player) . " won!";
    }


    public function render($field) {

      echo  "\n" .
            $this->toStone($field, 0) . " | " .
            $this->toStone($field, 1) . " | " .
            $this->toStone($field, 2) . "\n";
      echo  $this->toStone($field, 3) . " | " .
            $this->toStone($field, 4) . " | " .
            $this->toStone($field, 5) . "\n";
      echo  $this->toStone($field, 6) . " | " .
            $this->toStone($field, 7) . " | " .
            $this->toStone($field, 8) . "\n\n";
    }

    protected function toStone($field, $position) {

      $value = $field[$position];

      if ($value === null) {
        return "\e[2m" . $position . "\e[0m";
      }

      if ($value === true || $value === false) {
        return $this->playerToStone($value);
      }

      echo "wrong value at: " . $value;
      exit;
    }

    protected function playerToStone($isX) {
      if ($isX) {
        return "\e[95m" . "x" . "\e[0m";
      }

      return "\e[94m" . "o" . "\e[0m";
    }
}
?>
