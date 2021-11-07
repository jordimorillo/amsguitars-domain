<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\InterventionRepository;

use AMSGuitars\Domain\Entities\Intervention\InterventionRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Infrastructure\Exceptions\InterventionNotFound;
use AMSGuitars\Infrastructure\Persistence\InterventionRepository\InterventionRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Interventions;

class InterventionRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [InterventionRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $interventionRepositoryClass): void
    {
        /** @var InterventionRepositoryInterface $interventionRepository */
        $interventionRepository = new $interventionRepositoryClass();
        self::assertInstanceOf(InterventionRepositoryInterface::class, $interventionRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $guitarRepositoryClass): void
    {
        $anIntervention = (new Interventions())->anIntervention();
        /** @var InterventionRepositoryInterface $interventionRepository */
        $interventionRepository = new $guitarRepositoryClass();
        $interventionRepository->save($anIntervention);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $interventionRepositoryClass): void
    {
        $anIntervention = (new Interventions())->anIntervention();
        $interventionCollection = new InterventionCollection([$anIntervention]);
        /** @var InterventionRepositoryInterface $interventionRepository */
        $interventionRepository = new $interventionRepositoryClass($interventionCollection);
        $obtainedIntervention = $interventionRepository->findById($anIntervention->getInterventionId());
        self::assertEquals($anIntervention, $obtainedIntervention);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $guitarRepositoryClass): void
    {
        /** @var InterventionRepositoryInterface $guitarRepository */
        $guitarRepository = new $guitarRepositoryClass();
        $this->expectException(InterventionNotFound::class);
        $guitarRepository->findById(new InterventionId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $interventionRepositoryClass): void
    {
        $interventionCollection = new InterventionCollection();
        for ($i = 0; $i <= 10; $i++) {
            $anIntervention = (new Interventions())->anIntervention();
            $interventionCollection->add($anIntervention);
        }
        $findOrder = new SortOrder(new Column('interventionId'));
        $interventionCollection->sort($findOrder->getColumn()->toString());
        /** @var InterventionRepositoryInterface $interventionRepository */
        $interventionRepository = new $interventionRepositoryClass($interventionCollection);
        $obtainedCollection = $interventionRepository->findCollection($findOrder);
        self::assertEquals($interventionCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $interventionRepositoryClass): void
    {
        $interventionCollection = new InterventionCollection();
        for ($i = 1; $i <= 10; $i++) {
            $anIntervention = (new Interventions())->anIntervention();
            $interventionCollection->add($anIntervention);
        }
        /** @var InterventionRepositoryInterface $interventionRepository */
        $interventionRepository = new $interventionRepositoryClass($interventionCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('interventionId'), SortDirection::ASC());
        $interventionCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new InterventionCollection();
        foreach($interventionCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $interventionRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}