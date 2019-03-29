<?php

namespace App\Form;

use App\Entity\UserCharacters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserCharactersType extends AbstractType
{
    private $securityChecker;
    private $token;

    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $token)
    {
        $this->securityChecker = $securityChecker;
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('favorite')
            ->add('defaultCharacter')
            ->add('user')
            ->add('characters',\App\Form\Type\CharactersType::class)
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $userCharacters = $event->getData();
        $currentUser = $this->token->getToken()->getUser();


        if($userCharacters->getid() === null){
            if($this->securityChecker->isGranted('ROLE_ADMIN') === false){
                $userCharacters->setDefaultCharacter(false);
                $form->remove('defaultCharacter');
                $userCharacters->setFavorite(false);
                $form->remove('favorite');
                $userCharacters->setCreatedAt(new \DateTime('now'));
                $form->remove('createdAt');
                $userCharacters->setUser($currentUser);
                $form->remove('user');
            }
        }

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCharacters::class,
        ]);
    }
}
