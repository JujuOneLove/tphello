<?php

namespace App\UserItem;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class CalculateUserWeight{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function calculate(User $user): ?int{
        $lesItems = $this->em->getRepository('App\Entity\Item')->findBy(['user' => $user]);
        $poidActuel = 0;
        foreach ($lesItems as $item){
            $poidActuel += $item->getQuantity() * $item->getItemType()->getWeight();
        }
        return $poidActuel;
    }
}