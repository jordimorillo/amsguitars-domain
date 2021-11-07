<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Types;

use MyCLabs\Enum\Enum;

/**
 * @method static CLASSIC()
 * @method static MODERN()
 */
class GuitarType extends Enum
{
    public const CLASSIC = 'Classic';
    public const MODERN = 'Modern';
}