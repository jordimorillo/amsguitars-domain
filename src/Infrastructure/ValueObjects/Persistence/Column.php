<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Infrastructure\Exceptions\ColumnFormatException;

class Column implements StringValueObject
{
    private string $column;

    public function __construct(string $column) {
        $this->validate($column);
        $this->column = $column;
    }

    private function validate(string $column): void
    {
        if(preg_match('/^[a-zA-Z]+$/', $column) === 0) {
            throw new ColumnFormatException('Column '.$column.' has an invalid format');
        }
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->getColumn();
    }
}