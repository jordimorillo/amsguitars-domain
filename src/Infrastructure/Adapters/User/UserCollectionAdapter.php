<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\User;

use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;

class UserCollectionAdapter
{
    public static function fromRows(array $rows): UserCollection
    {
        $users = [];
        foreach($rows as $row) {
            $users[] = UserAdapter::fromRow($row);
        }
        return new UserCollection($users);
    }
}