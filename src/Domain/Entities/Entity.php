<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities;

interface Entity
{
    public function toArray(): array;
}