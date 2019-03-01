<?php

namespace App\EventListener;


use App\Entity\User;
use App\Event\ActionUserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ActionUserListener
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public function onActionUserCreate(ActionUserEvent  $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if($event->getActionUser()->getDirection() == "LEFT"){
            $user->setPositionX($user->getPositionX()-1);
        }
        elseif($event->getActionUser()->getDirection() == "BOTTOM"){
            $user->setPositionY($user->getPositionY()-1);
        }
        elseif($event->getActionUser()->getDirection() == "TOP"){
            $user->setPositionY($user->getPositionY()+1);
        }
        elseif($event->getActionUser()->getDirection() == "RIGHT"){
            $user->setPositionX($user->getPositionX()+1);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}