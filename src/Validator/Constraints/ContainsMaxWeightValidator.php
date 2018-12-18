<?php

namespace App\Validator\Constraints;

use App\Entity\Item;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use Doctrine\ORM\EntityManagerInterface;
use App\UserItem\CalculateUserWeight;

class ContainsMaxWeightValidator extends ConstraintValidator
{
    private $em;
    private $calculateUserWeight;

    public function __construct(EntityManagerInterface $em, CalculateUserWeight $calculateUserWeight)
    {
        $this->em = $em;
        $this->calculateUserWeight = $calculateUserWeight;
    }

    public function validate($value, Constraint $constraint) {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!($value instanceof Item)) {
            throw new UnexpectedTypeException($value, 'Item');
        }

        if (!$this->isPoidSuffisant($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ weight }}', $value->getQuantity())
                ->addViolation();
        }
    }

    private function isPoidSuffisant(Item $value) {
        // code à écrire
        $poidActuel = $this->calculateUserWeight->calculate($value->getUser());

        if(($value->getUser()->getMaxWeight() < $poidActuel + $value->getQuantity() * $value->getItemType()->getWeight()))
            return false;
        return true;
    }

    /*
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
                ->setParameter('{{ weight }}', $value->getQuantity())
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
    }*/
}
