<?php

namespace App\Validator;

use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class SolidPasswordValidator extends ConstraintValidator
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SolidPassword) {
            throw new UnexpectedTypeException($constraint, SolidPassword::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        $regex = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[$&+,:;=?@#|'<>.^*()%!-])(?=.*[a-z]).+$/";
        if (!preg_match($regex, $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}