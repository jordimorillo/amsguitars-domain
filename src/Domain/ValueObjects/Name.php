<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\NameInvalidException;

class Name implements StringValueObject
{
    private string $name;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    private function validate(string $name): void
    {
        if(preg_match('/^[A-Za-z]+$/', $name) === 0) {
            throw new NameInvalidException('Provided name '.$name.' is not valid');
        }
    }
}