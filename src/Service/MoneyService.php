<?php

namespace App\Service\;

use App\Controller\UserOrderController;
use App\Entity\UserOrder;
use App\Entity\UserProduct;

class MoneyService{

    public function gain(UserOrder $userOrder){

        if(!$bet instanceof Bet){
            throw new \InvalidArgumentException('Bet must be set');
        }
        $cote = $this->betIsWon->calcul($bet);
        return ($bet->getAmout() * $cote);

    }
}
