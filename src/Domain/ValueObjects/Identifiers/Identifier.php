<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Ramsey\Uuid\Uuid;

class Identifier implements StringValueObject
{
    private string $identifier;

    public function __construct(string $identifier = null)
    {
        if($identifier === null) {
            $uuid = Uuid::uuid4();
            $this->identifier = $uuid->toString();
        } else {
            $this->identifier = $identifier;
        }
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->identifier;
    }
}