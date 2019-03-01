<?php

namespace App\EventSubscriber;

use App\Event\AppEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ActionUserSubscriber implements EventSubscriberInterface{

    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::ActionUserCreate => 'onReset',
            AppEvent::ActionUserReset => 'onResetButton'
        ];
    }

    public function onResetButton()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $user->setPositionX(0);
        $user->setPositionY(0);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function onReset()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if(($user->getPositionX()>10)||($user->getPositionY()>10)||($user->getPositionX()<-10)||($user->getPositionY()<-10)){
            $user->setPositionX(0);
            $user->setPositionY(0);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}