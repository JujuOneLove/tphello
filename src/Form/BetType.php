<?php

namespace App\Form;

use App\Entity\Bet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreTeamA', \App\Form\Type\ScoreType::class)
            ->add('scoreTeamB', \App\Form\Type\ScoreType::class)
            ->add('date')
            ->add('amout')
            ->add('user')
            ->add('game')
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $bet = $event->getData();
        $form->remove('date');
        $form->remove('user');
        $form->remove('game');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bet::class,
        ]);
    }
}
