<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\CountryTooLongException;

class Country implements StringValueObject
{
    private const MAX_CHARACTERS = 120;
    private string $country;

    public function __construct(string $country)
    {
        if(strlen($country) > self::MAX_CHARACTERS) {
            throw new CountryTooLongException('Country exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->country = $country;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->country;
    }
}