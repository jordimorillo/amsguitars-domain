<?php

namespace AMSGuitars\Infrastructure\ValueObjects\Persistence;

use MyCLabs\Enum\Enum;

/**
 * @method static ASC()
 * @method static DESC()
 */
class SortDirection extends Enum
{
    public const ASC = 'asc';
    public const DESC = 'desc';
}