<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Order;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Domain\ValueObjects\Money;

class Order implements Entity
{
    public OrderId $orderId;
    public InterventionId $interventionId;
    public Money $totalWithoutTaxes;

    public function __construct(
        OrderId $orderId,
        InterventionId $interventionId,
        Money $totalWithoutTaxes
    ) {
        $this->orderId = $orderId;
        $this->interventionId = $interventionId;
        $this->totalWithoutTaxes = $totalWithoutTaxes;
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getInterventionId(): InterventionId
    {
        return $this->interventionId;
    }

    public function getTotalWithoutTaxes(): Money
    {
        return $this->totalWithoutTaxes;
    }

    public function toArray(): array
    {
        return [
            'orderId' => $this->getOrderId()->toString(),
            'interventionId' => $this->getInterventionId()->toString(),
            'totalWithoutTaxes' => $this->getTotalWithoutTaxes()->toFloat(),
        ];
    }
}