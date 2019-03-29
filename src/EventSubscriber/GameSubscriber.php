<?php

namespace App\EventSubscriber;
use App\Event\AppEvent;
use App\Event\GameEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
class GameSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function endGame(GameEvent $event)
    {
        $game = $event->getGame();
        $game->setEndGame(true);
        $this->entityManager->persist($game);
        $charactersRepository = $this->entityManager->getRepository('App\Entity\UserCharacters');
        $characters = $charactersRepository->findAll();
        foreach ($characters as $character) {
            if ($character->getDefaultCharacter() === true) {
                $character->setDefaultCharacter(false);
                $this->entityManager->persist($character);
            }
        }
        $userCharacters = $event->getGame()->getUserCharacters();
        $userCharacters->setDefaultCharacter(true);
        $this->entityManager->persist($userCharacters);

        $this->entityManager->flush();
    }
    public static function getSubscribedEvents()
    {
        return [
            AppEvent::EndGame => ['endGame', 128]
        ];
    }
}
