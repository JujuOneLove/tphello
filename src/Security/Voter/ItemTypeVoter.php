<?php

namespace App\Security\Voter;

use App\Security\AppAccess;
use App\Entity\User;
use App\Entity\ItemType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ItemTypeVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if ($attribute !== AppAccess::ITEM_TYPE_ACCESS ){
            return false;
        }

        if (!$subject instanceof ItemType) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {

            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') === true) {
            return true;
        }


        return $subject->getUser()->getId() === $user->getId();

    }
}