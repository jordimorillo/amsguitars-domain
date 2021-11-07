<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\GuitarRepository;

use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Infrastructure\Exceptions\GuitarNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use AMSGuitars\Infrastructure\Persistence\GuitarRepository\GuitarRepositoryInMemory;
use AMSGuitars\Domain\Entities\Guitar\GuitarRepositoryInterface;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Guitars;

class GuitarRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [GuitarRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $guitarRepositoryClass): void
    {
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass();
        self::assertInstanceOf(GuitarRepositoryInterface::class, $guitarRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $guitarRepositoryClass): void
    {
        $aGuitar = (new Guitars())->aGuitar();
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass();
        $guitarRepository->save($aGuitar);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $guitarRepositoryClass): void
    {
        $aGuitar = (new Guitars())->aGuitar();
        $guitarCollection = new GuitarCollection([$aGuitar]);
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass($guitarCollection);
        $obtainedGuitar = $guitarRepository->findById($aGuitar->getGuitarId());
        self::assertEquals($aGuitar, $obtainedGuitar);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $guitarRepositoryClass): void
    {
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass();
        $this->expectException(GuitarNotFound::class);
        $guitarRepository->findById(new GuitarId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $guitarRepositoryClass): void
    {
        $guitarCollection = new GuitarCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aGuitar = (new Guitars())->aGuitar();
            $guitarCollection->add($aGuitar);
        }
        $findOrder = new SortOrder(new Column('guitarId'));
        $guitarCollection->sort($findOrder->getColumn()->toString());
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass($guitarCollection);
        $obtainedCollection = $guitarRepository->findCollection($findOrder);
        self::assertEquals($guitarCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $guitarRepositoryClass): void
    {
        $guitarCollection = new GuitarCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aGuitar = (new Guitars())->aGuitar();
            $guitarCollection->add($aGuitar);
        }
        /** @var GuitarRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass($guitarCollection);
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