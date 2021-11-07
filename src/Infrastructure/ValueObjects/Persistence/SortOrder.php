<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\ValueObjects\Persistence;

class SortOrder
{
    private Column $column;
    private SortDirection $sortDirection;

    public function __construct(Column $column, SortDirection $sortDirection = null) {
        $this->column = $column;

        if($sortDirection === null) {
            $this->sortDirection = SortDirection::ASC();
        } else {
            $this->sortDirection = $sortDirection;
        }
    }

    public function getColumn(): Column
    {
        return $this->column;
    }

    public function getSortDirection(): SortDirection
    {
        return $this->sortDirection;
    }
}