<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\ModelRepository;

use AMSGuitars\Domain\Entities\Model\ModelRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\ModelCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Infrastructure\Exceptions\ModelNotFound;
use AMSGuitars\Infrastructure\Persistence\ModelRepository\ModelRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Models;

class ModelRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [ModelRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $interventionRepositoryClass): void
    {
        /** @var ModelRepositoryInterface $interventionRepository */
        $interventionRepository = new $interventionRepositoryClass();
        self::assertInstanceOf(ModelRepositoryInterface::class, $interventionRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $modelRepositoryClass): void
    {
        $aModel = (new Models())->aModel();
        /** @var ModelRepositoryInterface $modelRepository */
        $modelRepository = new $modelRepositoryClass();
        $modelRepository->save($aModel);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $modelRepositoryClass): void
    {
        $aModel = (new Models())->aModel();
        $modelCollection = new ModelCollection([$aModel]);
        /** @var ModelRepositoryInterface $modelRepository */
        $modelRepository = new $modelRepositoryClass($modelCollection);
        $obtainedModel = $modelRepository->findById($aModel->getModelId());
        self::assertEquals($aModel, $obtainedModel);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $modelRepositoryClass): void
    {
        /** @var ModelRepositoryInterface $modelRepository */
        $modelRepository = new $modelRepositoryClass();
        $this->expectException(ModelNotFound::class);
        $modelRepository->findById(new ModelId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $modelRepositoryClass): void
    {
        $modelCollection = new ModelCollection();
        for ($i = 0; $i <= 10; $i++) {
            $aModel = (new Models())->aModel();
            $modelCollection->add($aModel);
        }
        $findOrder = new SortOrder(new Column('modelId'));
        $modelCollection->sort($findOrder->getColumn()->toString());
        /** @var ModelRepositoryInterface $modelRepository */
        $modelRepository = new $modelRepositoryClass($modelCollection);
        $obtainedCollection = $modelRepository->findCollection($findOrder);
        self::assertEquals($modelCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $modelRepositoryClass): void
    {
        $modelCollection = new ModelCollection();
        for ($i = 1; $i <= 10; $i++) {
            $aModel = (new Models())->aModel();
            $modelCollection->add($aModel);
        }
        /** @var ModelRepositoryInterface $modelRepository */
        $modelRepository = new $modelRepositoryClass($modelCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('modelId'), SortDirection::ASC());
        $modelCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new ModelCollection();
        foreach($modelCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $modelRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}