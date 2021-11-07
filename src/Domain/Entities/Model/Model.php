<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Model;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Description;
use AMSGuitars\Domain\ValueObjects\Features;
use AMSGuitars\Domain\ValueObjects\Types\GuitarType;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Title;

class Model implements Entity
{
    public ModelId $modelId;
    public BrandId $brandId;
    public Title $title;
    private Description $description;
    public GuitarType $guitarType;
    private PhotoCollection $photoCollection;
    private ?Features $features;

    public function __construct(
        ModelId $modelId,
        BrandId $brandId,
        Title $title,
        Description $description,
        GuitarType $guitarType,
        PhotoCollection $photoCollection,
        ?Features $features
    ) {
        $this->modelId = $modelId;
        $this->brandId = $brandId;
        $this->title = $title;
        $this->description = $description;
        $this->guitarType = $guitarType;
        $this->photoCollection = $photoCollection;
        $this->features = $features;
    }

    public function getModelId(): ModelId
    {
        return $this->modelId;
    }

    public function getBrandId(): BrandId
    {
        return $this->brandId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getGuitarType(): GuitarType
    {
        return $this->guitarType;
    }

    public function getPhotoCollection(): PhotoCollection
    {
        return $this->photoCollection;
    }

    public function getFeatures(): ?Features
    {
        return $this->features;
    }

    public function toArray(): array
    {
        return [
            'modelId' => $this->getModelId()->toString(),
            'brandId' => $this->getBrandId()->toString(),
            'title' => $this->getTitle()->toString(),
            'description' => $this->getDescription()->toString(),
            'guitarType' => $this->getGuitarType()->getValue(),
            'photoCollection' => $this->getPhotoCollection()->toIdentifiersJson(),
            'features' => $this->getFeatures()->toString() ?? null,
        ];
    }
}