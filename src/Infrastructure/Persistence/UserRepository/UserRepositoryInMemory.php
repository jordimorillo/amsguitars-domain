<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\UserRepository;

use AMSGuitars\Domain\Entities\User\User;
use AMSGuitars\Domain\Entities\User\UserRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Infrastructure\Exceptions\UserNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class UserRepositoryInMemory implements UserRepositoryInterface
{
    private UserCollection $userCollection;

    public function __construct(UserCollection $userCollection = null)
    {
        $this->userCollection = $userCollection ?? new UserCollection();
    }

    public function save(User $user): void
    {
        $this->userCollection->add($user);
    }

    public function findById(UserId $userId): User
    {
        /** @var User $user */
        foreach($this->userCollection->getIterator() as $user) {
            if($user->getUserId() === $userId) {
                return $user;
            }
        }

        throw new UserNotFound('User with ID '.$userId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): UserCollection
    {
        /** @var UserCollection $collection */
        $collection = $this->userCollection->sort(
            $sortOrder->getColumn()->toString(),
            $sortOrder->getSortDirection()->getValue()
        );
        return $collection;
    }
}