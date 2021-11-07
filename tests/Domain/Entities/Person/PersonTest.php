<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Person;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Persons;

class PersonTest extends TestCase
{
    private Persons $persons;

    public function setUp(): void
    {
        parent::setUp();
        $this->persons = new Persons();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(Entity::class, $this->persons->aCustomer());
    }
}