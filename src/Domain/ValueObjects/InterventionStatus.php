<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects;

use MyCLabs\Enum\Enum;

/**
 * @method static RECEIVED()
 * @method static DIAGNOSED()
 * @method static UNDER_REPAIR()
 * @method static WAITING_FOR_MATERIAL()
 * @method static WAITING_TO_DELIVER()
 * @method static DELIVERED()
 * @method static CANCELLED()
 */
class InterventionStatus extends Enum implements StringValueObject
{
    public const RECEIVED = 'Received';
    public const DIAGNOSED = 'Diagnosed';
    public const UNDER_REPAIR = 'Under repair';
    public const WAITING_FOR_MATERIAL = 'Waiting for material';
    public const WAITING_TO_DELIVER = 'Waiting to deliver';
    public const DELIVERED = 'Delivered';
    public const CANCELLED = 'Cancelled';

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function toString(): string
    {
        return (string)$this;
    }
}