<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\User;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Users;

class UserTest extends TestCase
{
    private Users $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->users = new Users();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(Entity::class, $this->users->aUser());
    }

    public function testCanSerialize(): void
    {
        $user = $this->users->aUser();
        self::assertEquals(
            [
                'userId' => $user->getUserId()->toString(),
                'personId' => $user->getPersonId()->toString(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
            ],
            $user->toArray()
        );
    }
}