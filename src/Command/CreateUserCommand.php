<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:createuser';

    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder=$encoder;

        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $io = new SymfonyStyle($input, $output);
        $user->setEmail('test@test.fr');
        $user->setRoles(array());
        $user->setPlainPassword('test');
        $mdp = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($mdp);
        $user->setEnabled(true);
        $this->em->persist($user);
        $this->em->flush();
        $io->success('User est crée');
    }
}
