<?php

include "Renderer.php";

class Game
{
    public $field = array();
    public $isPlayerOne = true;
    public $renderer;

    function __construct() {
        $this->field = array_fill(0, 9, NULL);
        $this->renderer = new Renderer();

        return $this->play();
    }

    /*
    Plays through a game and handles the inputs from the renderer.

    Return bool|NULL $winner
    */
    protected function play() {
      $endCondition = false;
      $turn = 0;
      while (! $endCondition && $turn < 9) {
        $selectedTile = $this->renderer->getNewTile($this->field, $this->isPlayerOne);
        if ($this->validateTile($selectedTile)) {
          $this->field[(int)$selectedTile] = $this->isPlayerOne;
          $this->isPlayerOne = !$this->isPlayerOne;
        } else {
          $this->renderer->invalidTile();
        }
        $endCondition = $this->checkWinCondition();
        $turn++;
      }

      $this->renderer->render($this->field, $this->isPlayerOne);

      if ($endCondition === false) {
        $this->renderer->drawDraw();
      } else {
        $winner = (! $this->isPlayerOne);
        $this->renderer->winner($winner);

        return $winner;
      }
      return;
    }

    /*
    Checks is tile is already set
    Validates user input to be a number in correct range
    */
    protected function validateTile($tile) {
      if (  (int)$tile >= 0 && (int)$tile < 9
            && $this->field[$tile] === NULL
            && is_numeric($tile)) {
          return true;
      }
      return false;
    }

    /*
    Checks if game is won

    Return bool $isWon
    */
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

    /*
    Helper for checkWinCondition()

    Return bool $isSame
    */
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
