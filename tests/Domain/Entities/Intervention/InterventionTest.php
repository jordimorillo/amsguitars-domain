<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Intervention;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\Entities\Intervention\Intervention;
use AMSGuitars\Domain\ValueObjects\InterventionStatus;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Interventions;

class InterventionTest extends TestCase
{
    private Intervention $intervention;

    public function setUp(): void
    {
        $this->intervention = (new Interventions())->anIntervention();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(Entity::class, $this->intervention);
    }

    public function testCanBeSetAsReceived(): void
    {
        $this->intervention->received();
        self::assertEquals(InterventionStatus::RECEIVED(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsDiagnosed(): void
    {
        $this->intervention->diagnosed();
        self::assertEquals(InterventionStatus::DIAGNOSED(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsUnderRepair(): void
    {
        $this->intervention->underRepair();
        self::assertEquals(InterventionStatus::UNDER_REPAIR(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsWaitingForMaterial(): void
    {
        $this->intervention->waitingForMaterial();
        self::assertEquals(InterventionStatus::WAITING_FOR_MATERIAL(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsWaitingToDeliver(): void
    {
        $this->intervention->waitingToDeliver();
        self::assertEquals(InterventionStatus::WAITING_TO_DELIVER(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsDelivered(): void
    {
        $this->intervention->delivered();
        self::assertEquals(InterventionStatus::DELIVERED(), $this->intervention->getInterventionStatus());
    }

    public function testCanBeSetAsCancelled(): void
    {
        $this->intervention->cancelled();
        self::assertEquals(InterventionStatus::CANCELLED(), $this->intervention->getInterventionStatus());
    }
}