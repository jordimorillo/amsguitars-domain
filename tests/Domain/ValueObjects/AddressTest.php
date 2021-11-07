<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\AddressTooLongException;
use AMSGuitars\Domain\ValueObjects\Address;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $address = new Address($this->faker->address);
        self::assertInstanceOf(StringValueObject::class, $address);
    }

    public function testCanThrowAnExceptionWhenAddressExceedsMaxChars(): void
    {
        $addressTooLong = random_bytes(300);
        $this->expectException(AddressTooLongException::class);
        $address = new Address($addressTooLong);
    }
}