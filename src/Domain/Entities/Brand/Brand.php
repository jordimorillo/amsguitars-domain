<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Brand;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\ValueObjects\Name;

class Brand implements Entity
{
    public BrandId $brandId;
    public Name $name;

    public function __construct(BrandId $brandId, Name $name)
    {
        $this->brandId = $brandId;
        $this->name = $name;
    }

    public function getBrandId(): BrandId
    {
        return $this->brandId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'brandId' => $this->getBrandId()->toString(),
            'name' => $this->getName()->toString(),
        ];
    }
}