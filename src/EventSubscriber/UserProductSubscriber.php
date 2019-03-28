<?php

namespace App\EventSubscriber;
use App\Event\AppEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
class UserProductSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function onUserProductAdd($event)
    {
        $product = $event->getUserProduct()->getProduct();
        $product->setQuantity($product->getQuantity() - $event->getUserProduct()->getQuantity());
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
    public static function getSubscribedEvents()
    {
        return [
            AppEvent::UserProductRemoveQuantity => ['onUserProductAdd', 128]
        ];
    }
}
