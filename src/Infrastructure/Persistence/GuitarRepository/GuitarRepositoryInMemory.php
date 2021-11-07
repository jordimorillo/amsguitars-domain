<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\GuitarRepository;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\Entities\Guitar\GuitarRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Infrastructure\Exceptions\GuitarNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class GuitarRepositoryInMemory implements GuitarRepositoryInterface
{
    private GuitarCollection $guitarCollection;

    public function __construct(GuitarCollection $guitarCollection = null)
    {
        $this->guitarCollection = $guitarCollection ?? new GuitarCollection();
    }

    public function save(Guitar $guitar): void
    {
        $this->guitarCollection->add($guitar);
    }

    public function findById(GuitarId $guitarId): Guitar
    {
        /** @var Guitar $guitar */
        foreach($this->guitarCollection->getIterator() as $guitar) {
            if($guitar->getGuitarId() === $guitarId) {
                return $guitar;
            }
        }

        throw new GuitarNotFound('Guitar with ID '.$guitarId.' does not exist');
    }

    public function findCollection(SortOrder $order, Limit $limit = null): GuitarCollection
    {
        $guitarCollection = new GuitarCollection();
        $guitarCollection->sort($order->getColumn()->toString(), $order->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->guitarCollection->getIterator() as $key => $guitar) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $guitarCollection->add($guitar);
                }
            }
        } else {
            $guitarCollection = $this->guitarCollection;
        }

        return $guitarCollection;
    }
}