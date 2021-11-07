<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\RegionTooLongException;

class Region implements StringValueObject
{
    private const MAX_CHARACTERS = 100;
    private string $region;

    public function __construct(string $region)
    {
        if (strlen($region) > self::MAX_CHARACTERS) {
            throw new RegionTooLongException('Region exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->region = $region;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->region;
    }
}