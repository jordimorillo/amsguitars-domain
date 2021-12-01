<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\UserRepository;

use AMSGuitars\Domain\Entities\User\UserRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Infrastructure\Exceptions\UserNotFound;
use AMSGuitars\Infrastructure\Persistence\MySQL;
use AMSGuitars\Infrastructure\Persistence\UserRepository\UserRepositoryInMemory;
use AMSGuitars\Infrastructure\Persistence\UserRepository\UserRepositoryInMySQL;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use Tests\DatabaseTestCase;
use Tests\Fixtures\Domain\Users;

class UserRepositoryTest extends DatabaseTestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [new UserRepositoryInMemory()],
            'In MySQL' => [new UserRepositoryInMySQL(MySQL::getConnection())],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(UserRepositoryInterface $userRepository): void
    {
        self::assertInstanceOf(UserRepositoryInterface::class, $userRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(UserRepositoryInterface $userRepository): void
    {
        $aUser = (new Users())->aUser();
        $userRepository->save($aUser);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(UserRepositoryInterface $userRepository): void
    {
        $aUser = (new Users())->aUser();
        $userCollection = new UserCollection([$aUser]);
        foreach($userCollection->getIterator() as $user) {
            $userRepository->save($user);
        }
        $obtainedPhoto = $userRepository->findById($aUser->getUserId());
        self::assertEquals($aUser, $obtainedPhoto);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(UserRepositoryInterface $userRepository): void
    {
        $this->expectException(UserNotFound::class);
        $userRepository->findById(new UserId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(UserRepositoryInterface $userRepository): void
    {
        $totalItems = 10;
        $userCollection = new UserCollection();
        for ($i = 0; $i < $totalItems; $i++) {
            $aUser = (new Users())->aUser();
            $userCollection->add($aUser);
            $userRepository->save($aUser);
        }
        $findOrder = new SortOrder(new Column('userId'), SortDirection::ASC());
        $userCollectionOrdered = $userCollection->sort($findOrder->getColumn()->toString(), SortDirection::ASC);
        $obtainedCollection = $userRepository->findCollection($findOrder, new Limit(0, $totalItems));
        self::assertEquals($userCollectionOrdered, $obtainedCollection);
    }
}