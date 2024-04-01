<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class BirthdateMax extends Constraint
{
    public string $message = "Vous avez dépassé la date maximum.";

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