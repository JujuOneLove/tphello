<?php

namespace App\Service\WeaponUser;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WeaponUser;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TidyWeapon
{

    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function tidy(WeaponUser $weaponUser)
    {
        $weaponUser->setActive(false);
        $this->session->getFlashBag()->add('success', $weaponUser->getWeapon()->getName() . ' is tidy !');
        $this->em->flush();
    }
}

