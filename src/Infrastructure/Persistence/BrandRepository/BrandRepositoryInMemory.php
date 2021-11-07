<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\BrandRepository;

use AMSGuitars\Domain\Entities\Brand\Brand;
use AMSGuitars\Domain\Entities\Brand\BrandRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\BrandCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Infrastructure\Exceptions\BrandNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class BrandRepositoryInMemory implements BrandRepositoryInterface
{
    private BrandCollection $brandCollection;

    public function __construct(BrandCollection $brandCollection = null)
    {
        $this->brandCollection = $brandCollection ?? new BrandCollection();
    }

    public function save(Brand $brand): void
    {
        $this->brandCollection->add($brand);
    }

    public function findById(BrandId $brandId): Brand
    {
        /** @var Brand $brand */
        foreach($this->brandCollection->getIterator() as $brand) {
            if($brand->getBrandId() === $brandId) {
                return $brand;
            }
        }

        throw new BrandNotFound('Brand with ID '.$brandId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): BrandCollection
    {
        $brandCollection = new BrandCollection();
        $brandCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->brandCollection->getIterator() as $key => $brand) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $brandCollection->add($brand);
                }
            }
        } else {
            $brandCollection = $this->brandCollection;
        }

        return $brandCollection;
    }
}