<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\User\User;
use Ramsey\Collection\Collection;

class UserCollection extends Collection implements JsonValueObject
{
    /** @param User[] $users */
    public function __construct(array $users = [])
    {
        parent::__construct(User::class, $users);
    }

    public function toIdentifiersJson(): string
    {
        $users = [];
        /** @var User $user */
        foreach($this->getIterator() as $user) {
            $users[] = $user->getUserId()->toString();
        }
        return json_encode($users);
    }

    public function toJson(): string
    {
        $users = [];
        /** @var User $user */
        foreach($this->getIterator() as $user) {
            $users[] = $user->toArray();
        }
        return json_encode($users);
    }
}