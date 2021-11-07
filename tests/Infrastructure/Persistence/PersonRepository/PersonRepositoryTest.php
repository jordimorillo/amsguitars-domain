<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\PersonRepository;

use AMSGuitars\Domain\Entities\Person\PersonRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\PersonCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Infrastructure\Exceptions\PersonNotFound;
use AMSGuitars\Infrastructure\Persistence\PersonRepository\PersonRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Persons;

class PersonRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [PersonRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $personRepositoryClass): void
    {
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass();
        self::assertInstanceOf(PersonRepositoryInterface::class, $personRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $personRepositoryClass): void
    {
        $aPerson = (new Persons())->aCustomer();
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass();
        $personRepository->save($aPerson);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $personRepositoryClass): void
    {
        $aPerson = (new Persons())->aCustomer();
        $personCollection = new PersonCollection([$aPerson]);
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass($personCollection);
        $obtainedPerson = $personRepository->findById($aPerson->getPersonId());
        self::assertEquals($aPerson, $obtainedPerson);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $personRepositoryClass): void
    {
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass();
        $this->expectException(PersonNotFound::class);
        $personRepository->findById(new PersonId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $personRepositoryClass): void
    {
        $personCollection = new PersonCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aPerson = (new Persons())->aCustomer();
            $personCollection->add($aPerson);
        }
        $findOrder = new SortOrder(new Column('personId'));
        $personCollection->sort($findOrder->getColumn()->toString());
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass($personCollection);
        $obtainedCollection = $personRepository->findCollection($findOrder);
        self::assertEquals($personCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $personRepositoryClass): void
    {
        $personCollection = new PersonCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aPerson = (new Persons())->aCustomer();
            $personCollection->add($aPerson);
        }
        /** @var PersonRepositoryInterface $personRepository */
        $personRepository = new $personRepositoryClass($personCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('personId'), SortDirection::ASC());
        $personCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new PersonCollection();
        foreach($personCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $personRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}