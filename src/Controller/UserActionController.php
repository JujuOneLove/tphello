<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\WeaponUser;
use App\Service\WeaponUser\LoadWeapon;
use App\Service\WeaponUser\ReloadWeapon;
use App\Service\WeaponUser\ShootUser;
use App\Service\WeaponUser\ShootWeapon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user-action")
 */
class UserActionController extends AbstractController
{

    /**
     * @Route("/", name="user_action_index", methods="GET")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $weaponsUser = $em->getRepository(WeaponUser::class)->findBy(['user' => $this->getUser()]);

        $users = $em->getRepository(User::class)->findAllPlayerAlive($this->getUser());

        return $this->render('user_action/index.html.twig', ['weaponsUser' => $weaponsUser, 'users' => $users]);
    }


    /**
     * @Route("/reload/{id}", name="user_action_reload", methods="GET")
     */
    public function reload(WeaponUser $weaponUser, ReloadWeapon $reloadWeapon): Response
    {

        $reloadWeapon->reload($weaponUser);

        return $this->redirectToRoute('user_action_index');
    }

    /**
     * @Route("/load/{id}", name="user_action_load", methods="GET")
     */
    public function load(WeaponUser $weaponUser, LoadWeapon $loadWeapon): Response
    {
        $loadWeapon->load($weaponUser);

        return $this->redirectToRoute('user_action_index');
    }

    /**
     * @Route("/shoot/{id}", name="user_action_shoot", methods="GET")
     */
    public function shoot(User $user, ShootWeapon $shootWeapon): Response
    {
        $shootWeapon->shoot($user);

        return $this->redirectToRoute('user_action_index');
    }

    /**
     * @Route("/shootthesheriff/{id}", name="user_action_shootthesheriff", methods="GET", defaults={"id"=null})
     */
    public function shootTheSheriff(User $user = null, ShootUser $shootUser): Response
    {
        $shootUser->shootUser($user);

        return $this->redirectToRoute('user_action_index');
    }
}
