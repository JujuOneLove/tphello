<?php

namespace App\Validator;

use App\Entity\UserProduct;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class QuantityValidator extends ConstraintValidator
{
    protected $em;
    public function __construct(ObjectManager $entityManager) {
        $this->em = $entityManager;
    }
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint) {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!($value instanceof UserProduct)) {
            throw new UnexpectedTypeException($value, 'UserProduct');
        }

        if (!$this->isMaxQuantity($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @param UserProduct $value
     * @return bool
     */
    public function isMaxQuantity(UserProduct $value) {
        $produit = $value->getProduct();
        if ($produit->getQuantity() >= $value->getQuantity()) {
            return true;
        }
        return false;
    }
}
