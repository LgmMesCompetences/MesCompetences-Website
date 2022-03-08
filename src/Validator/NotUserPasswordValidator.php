<?php

namespace App\Validator;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NotUserPasswordValidator extends ConstraintValidator
{
    private UserPasswordHasherInterface $hasher;
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
        $this->tokenStorage = $tokenStorage;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof NotUserPassword) {
            throw new UnexpectedTypeException($constraint, NotUserPassword::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
        }

        $user = $this->tokenStorage->getToken()->getUser();

        if ($this->hasher->isPasswordValid($user, $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}