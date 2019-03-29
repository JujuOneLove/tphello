<?php

namespace App\Validator;

use App\Entity\Characters;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class CharactersValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }
        if (!($value instanceof Characters)) {
            throw new UnexpectedTypeException($value, 'Characters');
        }
        if ($this->isTeam($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isTeam(Characters $value)
    {
        $charactersRepository = $this->em->getRepository('App\Entity\Characters');
        $characters = $charactersRepository->findAll();
        foreach ($characters as $character) {
            if ($character->getName() === $value->getName()) {
                return true;
            }
        }
        return false;
    }
}
