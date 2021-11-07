<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\User;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Domain\ValueObjects\Password;
use AMSGuitars\Domain\ValueObjects\Username;

class User implements Entity
{
    public UserId $userId;
    private PersonId $personId;
    public Username $username;
    private Password $password;
    public Email $email;

    public function __construct(
        UserId $userId,
        PersonId $personId,
        Username $username,
        Password $password,
        Email $email
    ) {
        $this->userId = $userId;
        $this->personId = $personId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->getUserId()->toString(),
            'personId' => $this->getPersonId()->toString(),
            'username' => $this->getUsername()->toString(),
            'password' => $this->getPassword(),
            'email' => $this->getEmail()->toString(),
        ];
    }
}