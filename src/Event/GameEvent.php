<?php

namespace App\Event;

use App\Entity\Game;
use Symfony\Component\EventDispatcher\Event;

class GameEvent extends Event{

    /**
     * @var Game
     */
    private $game;
    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }
    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }


}
