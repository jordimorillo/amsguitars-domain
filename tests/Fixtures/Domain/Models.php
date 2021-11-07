<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\Entities\Model\Model;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Description;
use AMSGuitars\Domain\ValueObjects\Features;
use AMSGuitars\Domain\ValueObjects\Types\GuitarType;
use AMSGuitars\Domain\ValueObjects\Title;

class Models extends FakeEntityGenerator
{
    public function aModel(): Model
    {
        return new Model(
            new ModelId(),
            new BrandId(),
            new Title($this->faker->title),
            new Description($this->faker->text),
            GuitarType::CLASSIC(),
            new PhotoCollection(),
            new Features($this->faker->text),
        );
    }
}