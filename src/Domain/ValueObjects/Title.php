<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\TitleTooLongException;

class Title implements StringValueObject
{
    const MAX_CHARACTERS = 150;
    private string $title;

    public function __construct(string $title) {
        if(strlen($title) > self::MAX_CHARACTERS) {
            throw new TitleTooLongException('Title exceeds max ' . self::MAX_CHARACTERS . ' characters');
        }
        $this->title = $title;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}