<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\UsernameInvalidException;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Domain\ValueObjects\Username;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class UsernameTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $username = new Username($this->faker->userName);
        self::assertInstanceOf(StringValueObject::class, $username);
    }

    public function testCanThrowExceptionWhenInvalidCharsAreFound(): void
    {
        $invalidCharacters = ['"', '/', '\\', '[', ']', ':', ';', '|', '=', ',', '+', '*', '?', '<', '>', ' '];
        foreach($invalidCharacters as $invalidCharacter) {
            $usernameValue = $this->faker->userName;
            $invalidUsernameValue = $usernameValue.$invalidCharacter;
            $this->expectException(UsernameInvalidException::class);
            $username = new Username($invalidUsernameValue);
        }
    }
}