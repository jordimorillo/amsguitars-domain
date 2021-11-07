<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\UserRepository;

use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\Entities\User\UserRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use AMSGuitars\Infrastructure\Exceptions\UserNotFound;
use AMSGuitars\Infrastructure\Persistence\UserRepository\UserRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Users;

class UserRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [UserRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $userRepositoryClass): void
    {
        /** @var UserRepositoryInterface $userRepositoryClass */
        $userRepository = new $userRepositoryClass();
        self::assertInstanceOf(UserRepositoryInterface::class, $userRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $userRepositoryClass): void
    {
        $aUser = (new Users())->aUser();
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = new $userRepositoryClass();
        $userRepository->save($aUser);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $userRepositoryClass): void
    {
        $aUser = (new Users())->aUser();
        $userCollection = new UserCollection([$aUser]);
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = new $userRepositoryClass($userCollection);
        $obtainedPhoto = $userRepository->findById($aUser->getUserId());
        self::assertEquals($aUser, $obtainedPhoto);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $userRepositoryClass): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = new $userRepositoryClass();
        $this->expectException(UserNotFound::class);
        $userRepository->findById(new UserId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $userRepositoryClass): void
    {
        $userCollection = new UserCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aUser = (new Users())->aUser();
            $userCollection->add($aUser);
        }
        $findOrder = new SortOrder(new Column('userId'));
        $userCollection->sort($findOrder->getColumn()->toString());
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = new $userRepositoryClass($userCollection);
        $obtainedCollection = $userRepository->findCollection($findOrder);
        self::assertEquals($userCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $userRepositoryClass): void
    {
        $userCollection = new UserCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aUser = (new Users())->aUser();
            $userCollection->add($aUser);
        }
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = new $userRepositoryClass($userCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('userId'), SortDirection::ASC());
        $userCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new UserCollection();
        foreach($userCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $userRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}