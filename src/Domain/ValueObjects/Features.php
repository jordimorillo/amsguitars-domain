<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

class Features implements StringValueObject
{
    private string $features;

    public function __construct(string $features)
    {
        $this->features = $features;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->features;
    }
}