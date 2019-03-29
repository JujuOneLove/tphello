<?php

namespace App\Validator;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\UserCharacters;


class UserCharactersValidator extends ConstraintValidator
{
    private $em;
    private $token;
    public function __construct(ObjectManager $entityManager, TokenStorageInterface $token)
    {
        $this->em = $entityManager;
        $this->token = $token;
    }

    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }
        if (!($value instanceof UserCharacters)) {
            throw new UnexpectedTypeException($value, 'Characters');
        }
        if ($this->isCan($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isCan(UserCharacters $value)
    {
        $user = $this->token->getToken()->getUser();

        $charactersRepository = $this->em->getRepository('App\Entity\UserCharacters');
        $characters = $charactersRepository->findby(array('user' => $user));
        foreach ($characters as $character) {
            if ($character->getCharacters() === $value->getCharacters()) {
                return true;
            }
        }
        return false;
    }
}
