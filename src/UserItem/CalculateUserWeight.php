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

        $maxWeight = 100;

        return $maxWeight;
    }
}