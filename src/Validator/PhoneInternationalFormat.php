<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class PhoneInternationalFormat extends Constraint
{
    public string $message = "Le format du téléphone n'est pas bon. Exemple: +33 6 12 34 56 78";

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