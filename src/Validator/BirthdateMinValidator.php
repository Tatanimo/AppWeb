<?php

namespace App\Validator;

use App\Repository\UsersRepository;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class BirthdateMinValidator extends ConstraintValidator
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof BirthdateMin) {
            throw new UnexpectedTypeException($constraint, BirthdateMin::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!$value instanceof DateTime) {
            throw new UnexpectedValueException($value, 'string');
        }

        $date=date_create();
        date_sub($date,date_interval_create_from_date_string("99 years"));

        if (date_format($value, 'Y-m-d') < date_format($date, 'Y-m-d')) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}