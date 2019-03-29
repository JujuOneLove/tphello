<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GameType extends AbstractType
{
    private $userCharacters;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->userCharacters = $options['id'];

        $builder
            ->add('createdAt')
            ->add('position')
            ->add('assassination')
            ->add('reanimation')
            ->add('damage')
            ->add('userCharacters', EntityType::class, [
                'class' => \App\Entity\UserCharacters::class,
                'data' => $options['id']
            ])
            ->add('submit', SubmitType::class);
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $game = $event->getData();
        $game->setEndGame(false);

        $form->remove('submit');
        if ($game->getid() === null) {
            $form->add('submit', SubmitType::class, ['label' => 'Créer une partie']);

        } else {
            $form->add('submit', SubmitType::class, ['label' => 'Modifier une partie']);
        }
        if ($this->userCharacters !== null) {

            $game->setCreatedAt(new \DateTime('now'));
            $form->remove('createdAt');
            $game->setPosition(0);
            $form->remove('position');
            $game->setAssassination(0);
            $form->remove('assassination');
            $game->setReanimation(0);
            $form->remove('reanimation');
            $game->setDamage(0);
            $form->remove('damage');
            $game->setUserCharacters($this->userCharacters);
            $form->remove('userCharacters');
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'id' => null
        ]);
    }
}
