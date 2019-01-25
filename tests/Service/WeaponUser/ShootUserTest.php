<?php

namespace App\Tests\Service\WeaponUser;

use App\Entity\User;
use App\Entity\Weapon;
use App\Service\WeaponUser\CanShoot;
use App\Service\WeaponUser\ShootUser;
use PHPUnit\Framework\TestCase;

use App\Entity\WeaponUser;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class ShootUserTest extends TestCase{

    private function initShootUser($weaponUser){
        $repo = $this->createMock(WeaponUserRepository::class);
        $repo->expects($this->once())
            ->method('getWeaponUserActive')
            ->willReturn($weaponUser);

        $user = $this->createMock(User::class);

        $tokenToken = $this->createMock(PostAuthenticationGuardToken::class);
        $tokenToken->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $token = $this->createMock(TokenStorage::class);
        $token->expects($this->once())
            ->method('getToken')
            ->willReturn($tokenToken);

        $shoot = new CanShoot($repo);
        $shoot->setToken($token);

        return new ShootUser($em, $session, $token);
    }

    /**
     * @expectedException TypeError
     */
    public function testLoadWithNoWeaponUser(){

        $shootUser = $this->initShootUser();

        $shootUser->shootUser(null);
    }

    public function testLoadWithOneWeaponUnshootUser(){

        $weaponUser = new WeaponUser();
        $weapon = $this->createMock(Weapon::class);
        $weapon->expects($this->once())
            ->method('getName')
            ->willReturn('toto');

        $weaponUser->setWeapon($weapon);

        $shootUser = $this->initShootUser([$weaponUser]);

        $shootUser->shootUser($weaponUser);

        $this->assertTrue($weaponUser->getActive());
    }

    public function testLoadWithOneWeaponLoad(){

        $weaponUser = new WeaponUser();
        $weaponUser->setActive(true);
        $weapon = $this->createMock(Weapon::class);
        $weapon->expects($this->once())
            ->method('getName')
            ->willReturn('toto');
        $weaponUser->setWeapon($weapon);

        $shootUser = $this->initShootUser([$weaponUser]);

        $shootUser->shootUser($weaponUser);

        $this->assertTrue($weaponUser->getActive());
    }


    public function testLoadWithThreeWeaponMixLoad(){

        $weaponUser = new WeaponUser();
        $weaponUser->setActive(true);
        $weapon = $this->createMock(Weapon::class);
        $weapon->expects($this->once())
            ->method('getName')
            ->willReturn('toto');

        $weaponUser1 = clone($weaponUser);
        $weaponUser2 = clone($weaponUser);
        $weaponUser2->setActive(false);

        $weaponUser->setWeapon($weapon);

        $shootUser = $this->initShootUser([$weaponUser, $weaponUser1, $weaponUser2]);

        $shootUser->shootUser($weaponUser);

        $this->assertTrue($weaponUser->getActive());
    }

}