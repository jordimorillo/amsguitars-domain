<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\MoneyNotValidException;

class Money implements FloatValueObject
{
    private float $money;

    public function __construct(float $money)
    {
        $this->validate($money);
        $this->money = $money;
    }

    public function toFloat(): float
    {
        return $this->money;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return number_format($this->money, 2, '.', '');
    }

    private function validate(float $money)
    {
        if($this->hasDecimalValue($money) && preg_match('/^[0-9]+.[0-9]{1,2}$/', (string)$money) === 0) {
            throw new MoneyNotValidException('Provided money value '.$money.' is not correct');
        }
    }

    private function hasDecimalValue(float $money): bool
    {
        return strpos((string)$money, '.') > 0;
    }
}