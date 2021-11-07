<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\PasswordInvalidException;
use AMSGuitars\Domain\Exceptions\PasswordTooShortException;

class Password implements StringValueObject
{
    private const MIN_CHARACTERS = 8;
    private string $password;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->password = $password;
    }

    public function validate(string $password): void
    {
        if (strlen($password) < self::MIN_CHARACTERS) {
            throw new PasswordTooShortException('Password is less than ' . self::MIN_CHARACTERS . ' characters');
        }

        if (preg_match('/[\s]+/', $password)) {
            throw new PasswordInvalidException('Password contains an invalid character (space)');
        }

        if(preg_match('/[a-z]+/', $password) === 0) {
            throw new PasswordInvalidException('Password requires at least one lowercase character');
        }

        if(preg_match('/[A-Z]+/', $password) === 0) {
            throw new PasswordInvalidException('Password requires at least one uppercase character');
        }

        if(preg_match('/[0-9]+/', $password) === 0) {
            throw new PasswordInvalidException('Password requires at least one numeric character');
        }

        if(preg_match('/[%$.\-_]+/', $password) === 0) {
            throw new PasswordInvalidException('Password must contain a valid symbol: %$.-_');
        }
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}