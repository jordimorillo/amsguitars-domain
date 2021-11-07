<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\UsernameInvalidException;

class Username implements StringValueObject
{
    private array $invalidCharacters = ['"', '/', '\\', '[', ']', ':', ';', '|', '=', ',', '+', '*', '?', '<', '>', ' '];
    private string $userName;

    public function __construct(string $userName)
    {
        $this->validate($userName);
        $this->userName = $userName;
    }

    public function validate(string $userName): void
    {
        foreach ($this->invalidCharacters as $invalidCharacter) {
            if (strpos($userName, $invalidCharacter) > 0) {
                throw new UsernameInvalidException('Username contains invalid character: ' . $invalidCharacter);
            }
        }
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->userName;
    }
}