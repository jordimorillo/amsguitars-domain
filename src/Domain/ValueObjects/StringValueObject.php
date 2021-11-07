<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

interface StringValueObject
{
    public function toString(): string;
    public function __toString(): string;
}