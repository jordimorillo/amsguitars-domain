<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

interface JsonValueObject
{
    public function toIdentifiersJson(): string;
    public function toJson(): string;
}