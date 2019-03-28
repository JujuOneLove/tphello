<?php
namespace App\Security\Voter;
use App\Entity\UserOrder;
use App\Entity\UserProduct;
use App\Event\AppEvent;
use App\Repository\UserProductRepository;
use App\Security\AppAccess;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
class UserOrderVoter extends Voter
{

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [AppAccess::USERORDERSHOW, AppAccess::USERORDEREDIT])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!is_array($subject )) {
            return false;
        }

        return true;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        foreach ($subject as $s){
            if ($s->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
