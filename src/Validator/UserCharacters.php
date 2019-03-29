<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserCharacters extends Constraint
{
    public $message = 'on ne peut pas avoir 2 fois un UserCharacter avec le même User et le même Character';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
