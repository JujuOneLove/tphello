<?php

namespace App\Service\Bet;

use App\Entity\Bet;

class GainIsWon{
    private $betIsWon;

    public function __construct(BetIsWon $betIsWon)
    {
        $this->betIsWon = $betIsWon;
    }

    public function gain(Bet $bet = null){

        if(!$bet instanceof Bet){
            throw new \InvalidArgumentException('Bet must be set');
        }
        $cote = $this->betIsWon->calcul($bet);
        return ($bet->getAmout() * $cote);

    }
}
