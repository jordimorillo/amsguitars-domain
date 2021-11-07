<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Order;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Orders;

class OrderTest extends TestCase
{
    private Orders $orders;

    public function setUp(): void
    {
        parent::setUp();
        $this->orders = new Orders();
    }
    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(Entity::class, $this->orders->anOrder());
    }
}