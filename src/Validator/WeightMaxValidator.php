<?php

namespace App\Validator;

use App\Entity\Item;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WeightMaxValidator extends ConstraintValidator
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

        if (!($value instanceof Item)) {
            throw new UnexpectedTypeException($value, 'Item');
        }

        if (!$this->isMaxWeight($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isMaxWeight(Item $value) {
        $user = $value->getUser();
        $max= $user->getMaxWeight();
        $items=$this->em->getRepository(Item::class)->findby(array('user'=>$value->getUser()));
        $cpt=0;
        foreach ($items as $item){
            if($item instanceof Item) {
                $cpt += $item->getQuantity();
            }
        }
        if($cpt > $max){
            return false;
        }else return true;
    }
}
