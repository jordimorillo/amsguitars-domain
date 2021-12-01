<?php

namespace AMSGuitars\Infrastructure\Persistence\UserRepository;

use AMSGuitars\Domain\Entities\User\User;
use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $userId): User;

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): UserCollection;
}