<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\NameInvalidException;
use AMSGuitars\Domain\ValueObjects\Name;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $name = new Name('AMSGuitars');
        self::assertInstanceOf(StringValueObject::class, $name);
    }
    
    public function invalidNames(): array
    {
        return [
            'Name with numbers' => ['Numb34s'],
            'Name with symbols' => ['S!mb·|s'],
            'Name with spaces' => ['Something with spaces'],
        ];
    }
    
    /** @dataProvider invalidNames() */
    public function testCanThrowExceptionWhenNameIsNotValid(string $anInvalidName): void
    {
        $this->expectException(NameInvalidException::class);
        $name = new Name($anInvalidName);
    }
}