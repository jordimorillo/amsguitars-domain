<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\OrderRepository;

use AMSGuitars\Domain\Entities\Order\OrderRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\OrderCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Infrastructure\Exceptions\OrderNotFound;
use AMSGuitars\Infrastructure\Persistence\OrderRepository\OrderRepositoryInMemory;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Orders;

class OrderRepositoryTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'In memory' => [OrderRepositoryInMemory::class],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(string $orderRepositoryClass): void
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass();
        self::assertInstanceOf(OrderRepositoryInterface::class, $orderRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(string $orderRepositoryClass): void
    {
        $anOrder = (new Orders())->anOrder();
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass();
        $orderRepository->save($anOrder);
        self::assertTrue(true);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindById(string $orderRepositoryClass): void
    {
        $anOrder = (new Orders())->anOrder();
        $orderCollection = new OrderCollection([$anOrder]);
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass($orderCollection);
        $obtainedModel = $orderRepository->findById($anOrder->getOrderId());
        self::assertEquals($anOrder, $obtainedModel);
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionIfCantFindById(string $orderRepositoryClass): void
    {
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass();
        $this->expectException(OrderNotFound::class);
        $orderRepository->findById(new OrderId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollection(string $orderRepositoryClass): void
    {
        $orderCollection = new OrderCollection();
        for ($i = 0; $i <= 10; $i++) {
            $anOrder = (new Orders())->anOrder();
            $orderCollection->add($anOrder);
        }
        $findOrder = new SortOrder(new Column('orderId'));
        $orderCollection->sort($findOrder->getColumn()->toString());
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass($orderCollection);
        $obtainedCollection = $orderRepository->findCollection($findOrder);
        self::assertEquals($orderCollection, $obtainedCollection);
    }

    /** @dataProvider dataProvider() */
    public function testCanFindACollectionWithLimit(string $orderRepositoryClass): void
    {
        $orderCollection = new OrderCollection();
        for ($i = 1; $i <= 10; $i++) {
            $anOrder = (new Orders())->anOrder();
            $orderCollection->add($anOrder);
        }
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = new $orderRepositoryClass($orderCollection);
        $findLimit = new Limit(0, 2);
        $findOrder = new SortOrder(new Column('orderId'), SortDirection::ASC());
        $orderCollection->sort($findOrder->getColumn()->toString());
        $resultCollection = new OrderCollection();
        foreach($orderCollection->getIterator() as $key => $intervention) {
            if($key > $findLimit->getStartPosition() && $key <= $findLimit->getStartPosition() + $findLimit->getTotalItems()) {
                $resultCollection->add($intervention);
            }
        }
        $obtainedCollection = $orderRepository->findCollection($findOrder, $findLimit);
        self::assertEquals($resultCollection, $obtainedCollection);
    }
}