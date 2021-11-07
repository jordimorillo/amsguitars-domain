<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\PasswordInvalidException;
use AMSGuitars\Domain\Exceptions\PasswordTooShortException;
use AMSGuitars\Domain\ValueObjects\Password;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $password = new Password('AValid8CharacterPassword%');
        self::assertInstanceOf(StringValueObject::class, $password);
    }

    public function testCanThrowExceptionWhenIsTooShort(): void
    {
        $tooShortPassword = $this->faker->password(1, 7);
        $this->expectException(PasswordTooShortException::class);
        new Password($tooShortPassword);
    }

    public function testCanThrowExceptionWhenContainsNonAdmittedCharacters(): void
    {
        $invalidPassword = $this->faker->password(4, 8).' '.$this->faker->password(4, 8);
        $this->expectException(PasswordInvalidException::class);
        new Password($invalidPassword);
    }

    public function testCanThrowExceptionWhenDoesNotContainASingleMinusCharacter(): void
    {
        $invalidPassword = 'SOMETHINGUPPERCASE123';
        $this->expectException(PasswordInvalidException::class);
        new Password($invalidPassword);
    }

    public function testCanThrowExceptionWhenDoesNotContainASingleUpperCaseCharacter(): void
    {
        $invalidPassword = 'somethinglowercase123';
        $this->expectException(PasswordInvalidException::class);
        new Password($invalidPassword);
    }

    public function testCanThrowExceptionWhenDoesNotContainASingleNumberCharacter(): void
    {
        $invalidPassword = 'somethingWITHOUTNUMBER';
        $this->expectException(PasswordInvalidException::class);
        new Password($invalidPassword);
    }

    public function testCanThrowExceptionWhenDoesNotContainAnAcceptedSymbolCharacter(): void
    {
        $invalidPassword = 'SomethingWithout1Symbol';
        $this->expectException(PasswordInvalidException::class);
        new Password($invalidPassword);
    }
}