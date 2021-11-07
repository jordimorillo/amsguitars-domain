<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Order\Order;
use Ramsey\Collection\Collection;

class OrderCollection extends Collection implements JsonValueObject
{
    /** @param Order[] $persons */
    public function __construct(array $persons = [])
    {
        parent::__construct(Order::class, $persons);
    }

    public function toIdentifiersJson(): string
    {
        $orders = [];
        /** @var Order $order */
        foreach($this->getIterator() as $order) {
            $orders[] = $order->getOrderId()->toString();
        }
        return json_encode($orders);
    }

    public function toJson(): string
    {
        $orders = [];
        /** @var Order $order */
        foreach($this->getIterator() as $order) {
            $orders[] = $order->toArray();
        }
        return json_encode($orders);
    }
}