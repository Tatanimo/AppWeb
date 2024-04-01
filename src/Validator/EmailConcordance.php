<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class EmailConcordance extends Constraint
{
    public string $message = "L'email est déjà utilisé, veuillez choisir un autre.";

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