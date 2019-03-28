<?php

namespace App\Form;

use App\Entity\UserProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserProductType extends AbstractType
{
    private $securityChecker;
    private $token;

    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $token)
    {
        $this->securityChecker = $securityChecker;
        $this->token = $token;
    }
    private $product;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->product = $options['idP'];

        $builder
            ->add('quantity')
            ->add('createdAt')
            ->add('user')
            ->add('product', EntityType::class, [
                'class' => \App\Entity\Product::class,
                'choice_label' => 'name',
                'data' => $options['idP']
            ])
            ->add('userOrder')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $userP = $event->getData();
        $form = $event->getForm();

        if ($this->securityChecker->isGranted('ROLE_USER') === true) {
            $user = $this->token->getToken()->getUser();
            $userP->setUser($user);
            $form->remove('user');
        }
        if ($this->product !== null) {
            $userP->setProduct($this->product);
            $form->remove('product');
        }
        $userP->setCreatedAt(new \DateTime('@'.strtotime('now')));
        $form->remove('createdAt');

        $form->remove('userOrder');


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProduct::class,
            'idP' => null

        ]);
    }
}
