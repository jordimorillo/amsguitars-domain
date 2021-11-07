<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\FirstnameTooLongException;

class Firstname implements StringValueObject
{
    const MAX_CHARACTERS = 80;
    private string $firstname;

    public function __construct(string $firstname)
    {
        if (strlen($firstname) > self::MAX_CHARACTERS) {
            throw new FirstnameTooLongException('Firstname exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->firstname = $firstname;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->firstname;
    }
}