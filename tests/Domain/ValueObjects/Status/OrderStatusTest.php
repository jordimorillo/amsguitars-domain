<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Status;

use AMSGuitars\Domain\ValueObjects\Status\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function testHasTypePendingBudget(): void
    {
        $orderStatus = OrderStatus::PENDING_BUDGET();
        self::assertEquals('Pending budget', (string)$orderStatus);
    }

    public function testHasTypeBudgetAccepted(): void
    {
        $orderStatus = OrderStatus::BUDGET_ACCEPTED();
        self::assertEquals('Budget accepted', (string)$orderStatus);
    }

    public function testHasTypePendingInvoicing(): void
    {
        $orderStatus = OrderStatus::PENDING_INVOICING();
        self::assertEquals('Pending invoicing', (string)$orderStatus);
    }

    public function testHasTypeInvoiced(): void
    {
        $orderStatus = OrderStatus::INVOICED();
        self::assertEquals('Invoiced', (string)$orderStatus);
    }

    public function testHasPaymentComplete(): void
    {
        $orderStatus = OrderStatus::PAYMENT_COMPLETE();
        self::assertEquals('Payment complete', (string)$orderStatus);
    }
}