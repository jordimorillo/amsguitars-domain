<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Status;

use MyCLabs\Enum\Enum;

/**
 * @method static PENDING_BUDGET()
 * @method static BUDGET_ACCEPTED()
 * @method static PENDING_INVOICING()
 * @method static INVOICED()
 * @method static PAYMENT_COMPLETE()
 */
class OrderStatus extends Enum
{
    public const PENDING_BUDGET = 'Pending budget';
    public const BUDGET_ACCEPTED = 'Budget accepted';
    public const PENDING_INVOICING = 'Pending invoicing';
    public const INVOICED = 'Invoiced';
    public const PAYMENT_COMPLETE = 'Payment complete';
}