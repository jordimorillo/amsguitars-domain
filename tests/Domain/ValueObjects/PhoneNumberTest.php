<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\PhoneNumberInvalidException;
use AMSGuitars\Domain\ValueObjects\PhoneNumber;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }
    
    public function testCanInstantiate(): void
    {
        $phoneNumber = new PhoneNumber($this->faker->phoneNumber);
        self::assertInstanceOf(StringValueObject::class, $phoneNumber);
    }

    public function testCanThrowExceptionOnInvalidPhoneNumber(): void
    {
        $invalidPhoneNumber = random_bytes(9);
        $this->expectException(PhoneNumberInvalidException::class);
        $phoneNumber = new PhoneNumber($invalidPhoneNumber);
    }
}