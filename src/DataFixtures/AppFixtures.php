<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Weapon;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture {
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user@user.fr');
        $user1->setFirstName('user');
        $user1->setLastName('userlast');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user@user.fr'));
        $manager->persist($user1);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user1@user.fr');
        $user1->setFirstName('user1');
        $user1->setLastName('userlast1');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user1@user.fr'));
        $manager->persist($user1);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('user2@user.fr');
        $user1->setFirstName('user2');
        $user1->setLastName('userlast2');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'user2@user.fr'));
        $manager->persist($user1);

        $user1 = new User();
        $user1->setEnabled(true);
        $user1->setEmail('admin@admin.fr');
        $user1->setFirstName('admin');
        $user1->setLastName('admin');
        $user1->setRoles(array('ROLE_ADMIN', 'ROLE_USER'));
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'admin'));
        $manager->persist($user1);
        $manager->flush();

        $equipe1 = new Team();
        $equipe1->setName('France');
        $equipe1->setFlag('Bleu');
        $manager->persist($equipe1);
        $manager->flush();

        $equipe2 = new Team();
        $equipe2->setName('Belgique');
        $equipe2->setFlag('Seum');
        $manager->persist($equipe2);
        $manager->flush();

        $equipe3 = new Team();
        $equipe3->setName('Angleterre');
        $equipe3->setFlag('Thé');
        $manager->persist($equipe3);
        $manager->flush();

        $equipe4 = new Team();
        $equipe4->setName('Espagne');
        $equipe4->setFlag('Taurreau');
        $manager->persist($equipe4);
        $manager->flush();

        $equipe5 = new Team();
        $equipe5->setName('Suisse');
        $equipe5->setFlag('Yahourt');
        $manager->persist($equipe5);
        $manager->flush();

        $equipe6 = new Team();
        $equipe6->setName('Italie');
        $equipe6->setFlag('Pates');
        $manager->persist($equipe6);
        $manager->flush();

        $match1 = new Game();
        $match1->setTeamA($equipe1);
        $match1->setTeamB($equipe2);
        $match1->setScoreTeamA(1);
        $match1->setScoreTeamB(0);
        $match1->setDate(new DateTime('NOW'));
        $match1->setRating(1.4);
        $manager->persist($match1);
        $manager->flush();

        $match2 = new Game();
        $match2->setTeamA($equipe3);
        $match2->setTeamB($equipe4);
        $match2->setScoreTeamA(1);
        $match2->setScoreTeamB(2);
        $match2->setDate(new DateTime('NOW'));
        $match2->setRating(1.4);
        $manager->persist($match2);
        $manager->flush();

        $match3 = new Game();
        $match3->setTeamA($equipe5);
        $match3->setTeamB($equipe6);
        $match3->setScoreTeamA(1);
        $match3->setScoreTeamB(7);
        $match3->setDate(new DateTime('NOW'));
        $match3->setRating(1.4);
        $manager->persist($match3);
        $manager->flush();

        $match4 = new Game();
        $match4->setTeamA($equipe1);
        $match4->setTeamB($equipe3);
        $match4->setScoreTeamA(1);
        $match4->setScoreTeamB(0);
        $match4->setDate(new DateTime('NOW'));
        $match4->setRating(1.4);
        $manager->persist($match4);
        $manager->flush();

        $match5 = new Game();
        $match5->setTeamA($equipe2);
        $match5->setTeamB($equipe4);
        $match5->setScoreTeamA(1);
        $match5->setScoreTeamB(0);
        $match5->setDate(new DateTime('NOW'));
        $match5->setRating(1.4);
        $manager->persist($match5);
        $manager->flush();

    }
}
