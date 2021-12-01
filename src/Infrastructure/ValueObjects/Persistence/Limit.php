<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Infrastructure\Exceptions\LimitFormatException;

class Limit
{
    private int $offset;
    private int $totalItems;

    public function __construct(int $offset, int $totalItems)
    {
        $this->validate($offset, $totalItems);
        $this->offset = $offset;
        $this->totalItems = $totalItems;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getStartPosition(): int
    {
        return $this->getOffset() * $this->getTotalItems();
    }

    private function validate(int $offset, int $totalItems): void
    {
        if ($offset < 0 || $totalItems < 1) {
            throw new LimitFormatException(
                'Limit with offset ' . $offset . ' and totalItems ' . $totalItems . ' format invalid'
            );
        }
    }
}