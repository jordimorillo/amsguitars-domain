<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Types;

use MyCLabs\Enum\Enum;

/**
 * @method static CUSTOMER()
 * @method static ENDORSER()
 * @method static ADMINISTRATOR()
 */
class PersonType extends Enum
{
    public const CUSTOMER = 'Customer';
    public const ENDORSER = 'Endorser';
    public const ADMINISTRATOR = 'Administrator';
}