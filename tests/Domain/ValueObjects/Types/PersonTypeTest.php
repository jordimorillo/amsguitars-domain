<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Types;

use AMSGuitars\Domain\ValueObjects\Types\PersonType;
use PHPUnit\Framework\TestCase;

class PersonTypeTest extends TestCase
{
    public function testHasTypeCustomer(): void
    {
        self::assertEquals('Customer', PersonType::CUSTOMER);
    }

    public function testHasTypeEndorser(): void
    {
        self::assertEquals('Endorser', PersonType::ENDORSER);
    }

    public function testHasTypeAdministrator(): void
    {
        self::assertEquals('Administrator', PersonType::ADMINISTRATOR);
    }
}