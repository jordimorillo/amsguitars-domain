<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\EmailInvalidException;

class Email implements StringValueObject
{
    private const MAX_CHARACTERS = 255;
    private string $email;

    public function __construct(string $email)
    {
        if (strlen($email) > self::MAX_CHARACTERS) {
            throw new EmailInvalidException('Email exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailInvalidException('Email is not valid');
        }
        $this->email = $email;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}