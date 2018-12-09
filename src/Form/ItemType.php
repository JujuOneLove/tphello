<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItemType extends AbstractType
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
            ->add('name')
            ->add('itemType')
            ->add('quantity')
            ->add('user', null, ['choice_label' => 'email', 'placeholder' => false]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $item = $event->getData();
        $form = $event->getForm();

        if ($this->securityChecker->isGranted('ROLE_USER') === true) {
            $user = $this->token->getToken()->getUser();
            $item->setUser($user);
            $form->remove('user');
        }
        if($item->getId()){
            $form->remove('name');
            $form->remove('itemType');
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Item::class,
            ]
        );
    }
}
