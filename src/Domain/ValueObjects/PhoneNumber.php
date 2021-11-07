<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\PhoneNumberInvalidException;

class PhoneNumber implements StringValueObject
{
    private string $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        if ($this->validatePhoneNumber($phoneNumber) === false) {
            throw new PhoneNumberInvalidException('Phone number '.$phoneNumber.' is not valid');
        }
        $this->phoneNumber = $phoneNumber;
    }

    function validatePhoneNumber($phone): bool
    {
        $filteredPhoneNumber = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phoneToCheck = str_replace('-', '', $filteredPhoneNumber);
        $phoneToCheckLength = strlen($phoneToCheck);
        if ($phoneToCheckLength < 9 || $phoneToCheckLength > 12) {
            return false;
        }
        return true;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}