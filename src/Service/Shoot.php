<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\UserCharacters;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Shoot{

    public function kill(Game $game){
        if(!$game instanceof Game) {
            throw new InvalidArgumentException('Game must be set');
        }
        return $game->getAssassination()+1;
    }

    public function damage(Game $game){
        if(!$game instanceof Game) {
            throw new InvalidArgumentException('Game must be set');
        }
        return $game->getDamage()+100;
    }

    public function shoot(Game $game = null, $chance = null){

        if(!$game instanceof Game) {
            throw new InvalidArgumentException('Game must be set');
        }else{
            if($chance === null ) $chance = rand(0,100);
            if($chance<=20){
                $game->setAssassination($this->kill($game));
                $game->setDamage($this->damage($game));
            }elseif ($chance>20 && $chance<=70){
                $game->setDamage($this->damage($game));
            }
        }
        return $game;
    }

}
