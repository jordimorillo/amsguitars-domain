<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\InvalidZipcodeException;

class Zipcode implements StringValueObject
{
    private string $zipcode;

    public function __construct(string $zipcode)
    {
        $zipcodeLength = strlen($zipcode);
        if ((int)$zipcode < 5) {
            throw new InvalidZipcodeException('Provided zip code is a string: ' . $zipcode);
        }
        if ($zipcodeLength < 5) {
            throw new InvalidZipcodeException('Provided zip code is lesser than 5 chars: ' . $zipcode);
        }
        if ($zipcodeLength > 5) {
            throw new InvalidZipcodeException('Provided zip code is greater than 5 chars: ' . $zipcode);
        }
        $this->zipcode = $zipcode;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->zipcode;
    }
}