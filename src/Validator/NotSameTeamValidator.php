<?php

namespace App\Validator;

use App\Entity\Game;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotSameTeamValidator extends ConstraintValidator
{
    protected $em;
    public function __construct(ObjectManager $entityManager) {
        $this->em = $entityManager;
    }
    public function validate($value, Constraint $constraint) {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }
        if (!($value instanceof Game)) {
            throw new UnexpectedTypeException($value, 'Game');
        }
        if ($this->isTeam($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
    public function isTeam(Game $value) {
        if($value->getTeamA() === $value->getTeamB()){
            return true;
        }
        return false;
    }
}
