<?php

namespace App\Validator;

use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PhoneInternationalFormatValidator extends ConstraintValidator
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PhoneInternationalFormat) {
            throw new UnexpectedTypeException($constraint, PhoneInternationalFormat::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        $regex = "/^\+(?:[0-9] ?){6,14}[0-9]$/";
        if (!preg_match($regex, $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}