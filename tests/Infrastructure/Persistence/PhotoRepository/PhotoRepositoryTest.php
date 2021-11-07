<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\PhotoRepository;

use AMSGuitars\Domain\Entities\Photo\PersonRepositoryInterface;
use AMSGuitars\Domain\Entities\Photo\PhotoRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Infrastructure\Exceptions\PhotoNotFound;
use AMSGuitars\Infrastructure\Persistence\PhotoRepository\PhotoRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Photos;

class PhotoRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [PhotoRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $photoRepositoryClass): void
    {
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass();
        self::assertInstanceOf(PhotoRepositoryInterface::class, $photoRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $photoRepositoryClass): void
    {
        $aPhoto = (new Photos())->aPhoto();
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass();
        $photoRepository->save($aPhoto);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $photoRepositoryClass): void
    {
        $aPhoto = (new Photos())->aPhoto();
        $photoCollection = new PhotoCollection([$aPhoto]);
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass($photoCollection);
        $obtainedPhoto = $photoRepository->findById($aPhoto->getPhotoId());
        self::assertEquals($aPhoto, $obtainedPhoto);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $photoRepositoryClass): void
    {
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass();
        $this->expectException(PhotoNotFound::class);
        $photoRepository->findById(new PhotoId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $photoRepositoryClass): void
    {
        $photoCollection = new PhotoCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aPhoto = (new Photos())->aPhoto();
            $photoCollection->add($aPhoto);
        }
        $findOrder = new SortOrder(new Column('photoId'));
        $photoCollection->sort($findOrder->getColumn()->toString());
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass($photoCollection);
        $obtainedCollection = $photoRepository->findCollection($findOrder);
        self::assertEquals($photoCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $photoRepositoryClass): void
    {
        $photoCollection = new PhotoCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aPhoto = (new Photos())->aPhoto();
            $photoCollection->add($aPhoto);
        }
        /** @var PhotoRepositoryInterface $photoRepository */
        $photoRepository = new $photoRepositoryClass($photoCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('photoId'), SortDirection::ASC());
        $photoCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new PhotoCollection();
        foreach($photoCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $photoRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}