<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class SolidPassword extends Constraint
{
    public string $message = "Le mot de passe doit comporter une majuscule, une minuscule, un chiffre et un caractère spécial.";

    public function __construct(?array $options = null, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options ?? [], $groups, $payload);
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
{
    return static::class.'Validator';
}
}