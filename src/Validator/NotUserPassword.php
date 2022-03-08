<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class NotUserPassword extends Constraint
{
    public $message = 'This value cannot be your current password.';

    public function __construct(array $options = null, string $message = null,array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}