<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\Entities\User\User;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Password;
use AMSGuitars\Domain\ValueObjects\Username;

class Users extends FakeEntityGenerator
{
    public function aUser(): User
    {
        return new User(
            new UserId(),
            new PersonId(),
            new Username($this->faker->userName),
            new Password('AValid8CharacterPassword%'),
            new Email($this->faker->email)
        );
    }
}