<?php

namespace App\Event;

use App\Entity\ActionUser;
use Symfony\Component\EventDispatcher\Event;

class ActionUserEvent extends Event{

    /**@var \App\Entity\ActionUser
    */
    private $actionUser;

    /**
     * @return \App\Entity\ActionUser
     */
    public function getActionUser(): ActionUser
    {
        return $this->actionUser;
    }

    /**
     * @param \App\Entity\ActionUser $actionUser
     */
    public function setActionUser(ActionUser $actionUser)
    {
        $this->actionUser = $actionUser;
    }


}