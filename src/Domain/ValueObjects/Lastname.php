<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\LastnameTooLongException;

class Lastname implements StringValueObject
{
    const MAX_CHARACTERS = 150;
    private string $lastname;

    public function __construct(string $lastname)
    {
        if(strlen($lastname) > self::MAX_CHARACTERS) {
            throw new LastnameTooLongException('Lastname exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->lastname = $lastname;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->lastname;
    }
}