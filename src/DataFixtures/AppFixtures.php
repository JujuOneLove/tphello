<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

        $product1 = new Product();
        $product1->setName("Lait");
        $product1->setPrice(15.55);
        $product1->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $product1->setQuantity(10);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName("Eau");
        $product2->setPrice(12.55);
        $product2->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $product2->setQuantity(10);
        $manager->persist($product2);

        $product = new Product();
        $product->setName("Bière");
        $product->setPrice(25.55);
        $product->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $product->setQuantity(10);
        $manager->persist($product);

        $product = new Product();
        $product->setName("Mere");
        $product->setPrice(150.55);
        $product->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $product->setQuantity(10);
        $manager->persist($product);

        $product = new Product();
        $product->setName("Kebab");
        $product->setPrice(9.55);
        $product->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $product->setQuantity(10);
        $manager->persist($product);

        $userP = new UserProduct();
        $userP->setQuantity(5);
        $userP->setProduct($product1);
        $userP->setUser($user1);
        $userP->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $manager->persist($userP);

        $userP = new UserProduct();
        $userP->setQuantity(5);
        $userP->setProduct($product2);
        $userP->setUser($user1);
        $userP->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $manager->persist($userP);

        $manager->flush();
    }
}
