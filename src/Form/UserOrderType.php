<?php

namespace App\Form;

use App\Entity\UserOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('price')
            ->add('discount',\App\Form\Type\DiscountType::class)
            ->add('reference')
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }
    public function preSetData(FormEvent $event)
    {
        $userO = $event->getData();
        $form = $event->getForm();

        $userO->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $form->remove('createdAt');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserOrder::class,
        ]);
    }
}
