<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Brand\Brand;
use Ramsey\Collection\Collection;

class BrandCollection extends Collection implements JsonValueObject
{
    /** @param Brand[] $elements */
    public function __construct(array $elements = [])
    {
        parent::__construct(Brand::class, $elements);
    }

    public function toIdentifiersJson(): string
    {
        $brandIds = [];
        /** @var Brand $brand */
        foreach($this->getIterator() as $brand) {
            $brandIds[] = $brand->getBrandId()->toString();
        }
        return json_encode($brandIds);
    }

    public function toJson(): string
    {
        $brands = [];
        /** @var Brand $brand */
        foreach($this->getIterator() as $brand) {
            $brands[] = $brand->toArray();
        }
        return json_encode($brands);
    }
}