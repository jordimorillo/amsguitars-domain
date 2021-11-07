<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\DescriptionTooLongException;

class Description implements StringValueObject
{
    const MAX_CHARACTERS = 250;
    private ?string $description;

    public function __construct(string $description = null) {
        if(strlen($description) > self::MAX_CHARACTERS) {
            throw new DescriptionTooLongException('Description exceeds max '.self::MAX_CHARACTERS.' characters');
        }
        $this->description = $description;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}