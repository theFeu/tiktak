<?php

include "Renderer.php";

class Game
{
    public $field = array();
    public $currentPlayer = false;
    public $renderer;

    function __construct() {
        $this->field = array_fill(0, 9, NULL);
        $this->renderer = new Renderer();

        return $this->play();
      }

    protected function play() {
      $endCondition = false;
      $turn = 0;
      while (! $endCondition && $turn < 9) {
        $selectedTile = $this->renderer->getNewTile($this->field, $this->currentPlayer);
        if ($this->validateTile($selectedTile)) {
          $this->field[(int)$selectedTile] = $this->currentPlayer;
          $this->currentPlayer = !$this->currentPlayer;
        } else {
          $this->renderer->invalidTile();
        }
        $endCondition = $this->checkWinCondition();
        $turn++;
      }

      $this->renderer->render($this->field, $this->currentPlayer);

      if ($endCondition === false) {
        $this->renderer->drawDraw();
      } else {
        $this->renderer->winner(! $this->currentPlayer);
      }
      return;
    }

    protected function validateTile($tile) {
      if (is_numeric($tile) && $this->field[$tile] === NULL) {
          return true;
      }
      return false;
    }

    protected function checkWinCondition() {
      // horizontal
      if ($this->compareThree(0,1,2)) { return true; }
      if ($this->compareThree(3,4,5)) { return true; }
      if ($this->compareThree(6,7,8)) { return true; }

      // vertical
      if ($this->compareThree(0,3,6)) { return true; }
      if ($this->compareThree(1,4,7)) { return true; }
      if ($this->compareThree(2,5,8)) { return true; }

      // axis
      if ($this->compareThree(0,4,8)) { return true; }
      if ($this->compareThree(2,4,6)) { return true; }

      return false;
    }

    protected function compareThree($first, $second, $third) {
      if (  $this->field[$first] !== NULL
            && $this->field[$first] === $this->field[$second]
            && $this->field[$first] === $this->field[$third]) {
        return true;
      }

      return;
    }
}
?>
