<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\User;

use AMSGuitars\Domain\Entities\User\User;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Domain\ValueObjects\Password;
use AMSGuitars\Domain\ValueObjects\Username;

class UserAdapter
{
    public static function fromRow(array $row): User
    {
        return new User(
            new UserId($row['userId']),
            new PersonId($row['personId']),
            new Username($row['username']),
            new Password($row['password']),
            new Email($row['email'])
        );
    }
}