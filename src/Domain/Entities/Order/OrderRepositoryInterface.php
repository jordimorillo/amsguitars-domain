<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Order;

use AMSGuitars\Domain\ValueObjects\Collections\OrderCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
    public function findById(OrderId $orderId): Order;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): OrderCollection;
}