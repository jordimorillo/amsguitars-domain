<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\AddressTooLongException;

class Address implements StringValueObject
{
    const MAX_CHARACTERS = 255;
    private string $address;

    public function __construct(string $address)
    {
        if(strlen($address) > self::MAX_CHARACTERS) {
            throw new AddressTooLongException('Address exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->address = $address;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->address;
    }
}