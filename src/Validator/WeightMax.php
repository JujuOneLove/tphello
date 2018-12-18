<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WeightMax extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'vous ne pouvez pas de dépasser le poids max de l\'utilisateur';
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
