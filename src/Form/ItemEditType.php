<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemEditType extends ItemType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('name')
            ->remove('itemType')
            ->remove('user');
    }

}
