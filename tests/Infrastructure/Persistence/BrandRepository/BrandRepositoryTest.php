<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\BrandRepository;

use AMSGuitars\Domain\Entities\Brand\BrandRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\BrandCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Infrastructure\Exceptions\BrandNotFound;
use AMSGuitars\Infrastructure\Persistence\BrandRepository\BrandRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Brands;

class BrandRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [BrandRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $brandRepositoryClass): void
    {
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass();
        self::assertInstanceOf(BrandRepositoryInterface::class, $brandRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $brandRepositoryClass): void
    {
        $aBrand = (new Brands())->aBrand();
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass();
        $brandRepository->save($aBrand);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $brandRepositoryClass): void
    {
        $aBrand = (new Brands())->aBrand();
        $brandCollection = new BrandCollection([$aBrand]);
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass($brandCollection);
        $obtainedBrand = $brandRepository->findById($aBrand->getBrandId());
        self::assertEquals($aBrand, $obtainedBrand);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $brandRepositoryClass): void
    {
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass();
        $this->expectException(BrandNotFound::class);
        $brandRepository->findById(new BrandId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $brandRepositoryClass): void
    {
        $brandCollection = new BrandCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aBrand = (new Brands())->aBrand();
            $brandCollection->add($aBrand);
        }
        $findOrder = new SortOrder(new Column('brandId'));
        $brandCollection->sort($findOrder->getColumn()->toString());
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass($brandCollection);
        $obtainedCollection = $brandRepository->findCollection($findOrder);
        self::assertEquals($brandCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $brandRepositoryClass): void
    {
        $brandCollection = new BrandCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aBrand = (new Brands())->aBrand();
            $brandCollection->add($aBrand);
        }
        /** @var BrandRepositoryInterface $brandRepository */
        $brandRepository = new $brandRepositoryClass($brandCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('brandId'), SortDirection::ASC());
        $brandCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new BrandCollection();
        foreach($brandCollection->getIterator() as $key => $guitar) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($guitar);
            }
        }
        $obtainedCollection = $brandRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}