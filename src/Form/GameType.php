<?php

namespace App\Form;

use DateTime;
use App\Entity\Game;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    private $teamA;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->teamA = $options['teamA'];
        $builder
            ->add('scoreTeamA')
            ->add('scoreTeamB')
            ->add('date')
            ->add('rating')
            ->add('teamA', EntityType::class, [
                'class' => \App\Entity\Team::class,
                'choice_label' => 'name',
                'data' => $options['teamA']
            ])
            ->add('teamB');
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $game = $event->getData();
        if ($this->teamA !== null) {
            $game->setTeamA($this->teamA);
            $game->setDate(new DateTime('now'));
            $form->remove('teamA');
            $form->remove('scoreTeamA');
            $form->remove('scoreTeamB');
            $form->remove('date');
            $form->remove('rating');
        }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'teamA' => null
        ]);
    }
}
