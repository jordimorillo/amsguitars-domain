<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\GuitarRepository;

use AMSGuitars\Domain\Entities\Guitar\GuitarRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Infrastructure\Exceptions\GuitarNotFound;
use AMSGuitars\Infrastructure\Persistence\GuitarRepository\GuitarRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use Tests\DatabaseTestCase;
use Tests\Fixtures\Domain\Guitars;

class GuitarRepositoryTest extends DatabaseTestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [new GuitarRepositoryInMemory],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(GuitarRepositoryInterface $guitarRepository): void
    {
        self::assertInstanceOf(GuitarRepositoryInterface::class, $guitarRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(GuitarRepositoryInterface $guitarRepository): void
    {
        $aGuitar = (new Guitars())->aGuitar();
        $guitarRepository->save($aGuitar);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(GuitarRepositoryInterface $guitarRepository): void
    {
        $aGuitar = (new Guitars())->aGuitar();
        $guitarCollection = new GuitarCollection([$aGuitar]);
        foreach($guitarCollection->getIterator() as $guitar) {
            $guitarRepository->save($guitar);
        }
        $obtainedGuitar = $guitarRepository->findById($aGuitar->getGuitarId());
        self::assertEquals($aGuitar, $obtainedGuitar);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(GuitarRepositoryInterface $guitarRepository): void
    {
        $this->expectException(GuitarNotFound::class);
        $guitarRepository->findById(new GuitarId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(GuitarRepositoryInterface $guitarRepository): void
    {
        $guitarCollection = new GuitarCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aGuitar = (new Guitars())->aGuitar();
            $guitarCollection->add($aGuitar);
            $guitarRepository->save($aGuitar);
        }
        $findOrder = new SortOrder(new Column('guitarId'));
        $guitarCollection->sort($findOrder->getColumn()->toString());
        $obtainedCollection = $guitarRepository->findCollection($findOrder);
        self::assertEquals($guitarCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(GuitarRepositoryInterface $guitarRepository): void
    {
        $guitarCollection = new GuitarCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aGuitar = (new Guitars())->aGuitar();
            $guitarCollection->add($aGuitar);
            $guitarRepository->save($aGuitar);
        }
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('guitarId'), SortDirection::ASC());
        $guitarCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new GuitarCollection();
        $startPosition = $findLimit->getOffset() * $findLimit->getTotalItems();
        foreach($guitarCollection->getIterator() as $key => $guitar) {
            if($key > $startPosition && $key <= $startPosition + $findLimit->getTotalItems()) {
                $resultCollection->add($guitar);
            }
        }
        $obtainedCollection = $guitarRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}