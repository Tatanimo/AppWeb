<?php

namespace App\Validator;

use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EmailConcordanceValidator extends ConstraintValidator
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EmailConcordance) {
            throw new UnexpectedTypeException($constraint, EmailConcordance::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        if ($this->usersRepository->findOneByEmail($value) !== null) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}