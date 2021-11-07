<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\Entities\Brand\Brand;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\ValueObjects\Name;

class Brands extends FakeEntityGenerator
{
    public function aBrand(): Brand
    {
        return new Brand(
            new BrandId(),
            new Name($this->faker->word)
        );
    }
}