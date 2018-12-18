<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\RolesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
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
            ->add('email')
            ->add('plainPassword')
            ->add('roles', RolesType::class)
            ->add('pictureFile', FileType::class, array('label' => 'Image'))
            ->add('submit', SubmitType::class, ['label_format' => 'Registration']);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $user = $event->getData();
        $currentUser = $this->token->getToken()->getUser();
        /* @Explain Si Role Super ADMIN alors on ajoute un champ active sinon on enleve le role
         * if($this->securityChecker->isGranted('ROLE_SUPER_ADMIN') === true){
         * $form->add('enabled');
         * }else{
         * $form->remove('roles');
         * }
         */

        if($user->getid() !== null){
            $user->setMaxWeight(\rand(200, 500));
            if(($user->getid() == $currentUser->getid())===false){
                if($this->securityChecker->isGranted('ROLE_ADMIN') === false){
                    $form->remove('pictureFile');
                }
            }
        }



        /* ici on peux directement setter des valeur a user ! */
        $user->setEnabled(true);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
                'itemtype' => null,
            ]
        );
    }
}
