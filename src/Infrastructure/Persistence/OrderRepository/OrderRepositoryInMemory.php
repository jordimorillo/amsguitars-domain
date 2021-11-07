<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\OrderRepository;

use AMSGuitars\Domain\Entities\Order\Order;
use AMSGuitars\Domain\Entities\Order\OrderRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\OrderCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Infrastructure\Exceptions\OrderNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class OrderRepositoryInMemory implements OrderRepositoryInterface
{
    private OrderCollection $orderCollection;

    public function __construct(OrderCollection $orderCollection = null)
    {
        $this->orderCollection = $orderCollection ?? new OrderCollection();
    }

    public function save(Order $order): void
    {
        $this->orderCollection->add($order);
    }

    public function findById(OrderId $orderId): Order
    {
        /** @var Order $order */
        foreach($this->orderCollection->getIterator() as $order) {
            if($order->getOrderId() === $orderId) {
                return $order;
            }
        }

        throw new OrderNotFound('Order with ID '.$orderId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): OrderCollection
    {
        $orderCollection = new OrderCollection();
        $orderCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->orderCollection->getIterator() as $key => $intervention) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $orderCollection->add($intervention);
                }
            }
        } else {
            $orderCollection = $this->orderCollection;
        }

        return $orderCollection;
    }
}