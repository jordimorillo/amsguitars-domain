<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\UserRepository;

use AMSGuitars\Domain\Entities\User\User;
use AMSGuitars\Domain\Entities\User\UserRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Domain\ValueObjects\Password;
use AMSGuitars\Domain\ValueObjects\Username;
use AMSGuitars\Infrastructure\Exceptions\UserNotFound;
use AMSGuitars\Infrastructure\Exceptions\UserRepositoryException;
use AMSGuitars\Infrastructure\Persistence\Repository;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use mysqli;

class UserRepositoryInMySQL implements UserRepositoryInterface, Repository
{
    private mysqli $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function save(User $user): void
    {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO users (`userId`, `personId`, `username`, `password`, `email`) VALUES (?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE `personId`=VALUES(`personId`), `username`=VALUES(`username`), `password`=VALUES(`password`), `email`=VALUES(`email`);"
        );
        $stmt->bind_param('sssss', $userId, $personId, $username, $password, $email);
        $userId = $user->getUserId()->toString();
        $personId = $user->getPersonId()->toString();
        $username = $user->getUsername()->toString();
        $password = $user->getPassword()->toString();
        $email = $user->getEmail()->toString();
        if ($stmt->execute() === false) {
            throw new UserRepositoryException('Failed saving the user ' . $userId);
        }
    }

    public function findById(UserId $userId): User
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM users WHERE `userId`=?');
        $stmt->bind_param('s', $userIdValue);
        $userIdValue = $userId->toString();
        if ($stmt->execute() === false) {
            throw new UserRepositoryException('Failed while finding the user ' . $userId);
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row === null) {
            throw new UserNotFound('User ' . $userId . ' not found');
        }
        return $this->userFromRow($row);
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit): UserCollection
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM users ORDER BY ? LIMIT ?,?');
        $stmt->bind_param('sii', $sortOrderValue, $limitStart, $limitEnd);
        $sortOrderValue = $sortOrder->getColumn()->toString() . ' ' . $sortOrder->getSortDirection()->getValue();
        $limitStart = $limit->getStartPosition();
        $limitEnd = $limit->getTotalItems();
        if ($stmt->execute() === false) {
            throw new UserRepositoryException('Failed while finding the user collection');
        }
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $this->userFromRow($row);
        }
        return new UserCollection($users);
    }

    private function userFromRow(array $row): User
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