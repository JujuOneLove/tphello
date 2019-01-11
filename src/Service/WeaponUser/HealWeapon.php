<?php

namespace App\Service\WeaponUser;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HealWeapon{

    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function heal(User $user){
        $heal=1000-$user->getHealth();
        $user->setHealth($user->getHealth()+$heal);
        $this->session->getFlashBag()->add('success', $user->getFirstName().' '.$user->getLastName().'a été soigné');
        $this->em->flush();
    }
}

