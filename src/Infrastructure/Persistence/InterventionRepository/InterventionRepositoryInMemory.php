<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\InterventionRepository;

use AMSGuitars\Domain\Entities\Intervention\Intervention;
use AMSGuitars\Domain\Entities\Intervention\InterventionRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Infrastructure\Exceptions\InterventionNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class InterventionRepositoryInMemory implements InterventionRepositoryInterface
{
    private InterventionCollection $interventionCollection;

    public function __construct(InterventionCollection $interventionCollection = null)
    {
        $this->interventionCollection = $interventionCollection ?? new InterventionCollection();
    }

    public function save(Intervention $intervention): void
    {
        $this->interventionCollection->add($intervention);
    }

    public function findById(InterventionId $interventionId): Intervention
    {
        /** @var Intervention $intervention */
        foreach($this->interventionCollection->getIterator() as $intervention) {
            if($intervention->getInterventionId() === $interventionId) {
                return $intervention;
            }
        }

        throw new InterventionNotFound('Intervention with ID '.$interventionId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): InterventionCollection
    {
        $interventionCollection = new InterventionCollection();
        $interventionCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->interventionCollection->getIterator() as $key => $intervention) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $interventionCollection->add($intervention);
                }
            }
        } else {
            $interventionCollection = $this->interventionCollection;
        }

        return $interventionCollection;
    }
}