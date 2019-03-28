<?php

namespace App\Event;

use App\Entity\UserProduct;
use Symfony\Component\EventDispatcher\Event;

class UserProductEvent extends Event{

    /**
     * @var UserProduct
     */
    private $userProduct;
    /**
     * @return UserProduct
     */
    public function getUserProduct(): UserProduct
    {
        return $this->userProduct;
    }
    /**
     * @param UserProduct $userProduct
     */
    public function setUserProduct(UserProduct $userProduct): void
    {
        $this->userProduct = $userProduct;
    }


}
