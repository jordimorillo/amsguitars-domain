<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

interface FloatValueObject
{
    public function toFloat(): float;
    public function toString(): string;
    public function __toString(): string;
}