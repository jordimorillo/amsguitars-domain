<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\Entities\Order\Order;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Money;

class Orders extends FakeEntityGenerator
{
    public function anOrder(): Order
    {
        return new Order(
            new OrderId(),
            new InterventionId(),
            new Money($this->faker->randomFloat(2))
        );
    }
}