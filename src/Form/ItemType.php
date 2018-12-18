<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ItemType extends AbstractType
{
    private $itemType;

    private $securityChecker;
    private $token;

    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $token)
    {
        $this->securityChecker = $securityChecker;
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->itemType = $options['itemType'];

        $builder
            ->add('name')
            ->add('itemType', EntityType::class, [
                'class' => \App\Entity\ItemType::class,
                'choice_label' => 'name',
                'data' => $options['itemType']
            ])
            ->add('quantity')
            ->add('user', null, ['choice_label' => 'email', 'placeholder' => false]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $item = $event->getData();

        $label = 'créer';

        //@explain item create
        if($item->getId() === null){

            //@explain set User and remove user field in form
            $item->setUser($this->token->getToken()-> getUser());
            $form->remove('user');

            //@explain if we have itemType we set it and remove field
            if($this->itemType !== null){
                $item->setItemType($this->itemType);
                $form->remove('itemType');
            }

        }else{
            //@explain on edit we remove all field except quantity
            $form->remove('user')->remove('itemType')->remove('name');
            $label = 'Editer';
        }

        $form->add('submit', SubmitType::class, ['attr' => ['class' => 'save'], 'label' => $label]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Item::class,
                'itemType' => null
            ]
        );
    }
}
