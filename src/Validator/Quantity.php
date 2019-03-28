<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Quantity extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'vous ne pouvez pas de dépasser le quantity disponible d\'un produit';
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
