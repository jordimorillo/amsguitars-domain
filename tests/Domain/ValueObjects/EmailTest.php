<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\EmailInvalidException;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }
    
    public function testCanInstantiate(): void
    {
        $email = new Email($this->faker->email);
        self::assertInstanceOf(StringValueObject::class, $email);
    }

    public function invalidEmails(): array
    {
        return [
            'Too long email' => [random_bytes(300)],
            'Not an email' => [random_bytes(150)],
        ];
    }

    /** @dataProvider invalidEmails() */
    public function testCanThrowExceptionWhenIsInvalid(string $invalidEmail): void
    {
        $this->expectException(EmailInvalidException::class);
        $email = new Email($invalidEmail);
    }
}