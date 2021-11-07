<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\PhotoRepository;

use AMSGuitars\Domain\Entities\Photo\Photo;
use AMSGuitars\Domain\Entities\Photo\PhotoRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Infrastructure\Exceptions\PhotoNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class PhotoRepositoryInMemory implements PhotoRepositoryInterface
{
    private PhotoCollection $photoCollection;

    public function __construct(PhotoCollection $photoCollection = null)
    {
        $this->photoCollection = $photoCollection ?? new PhotoCollection();
    }

    public function save(Photo $photo): void
    {
        $this->photoCollection->add($photo);
    }

    public function findById(PhotoId $photoId): Photo
    {
        /** @var Photo $photo */
        foreach($this->photoCollection->getIterator() as $photo) {
            if($photo->getPhotoId() === $photoId) {
                return $photo;
            }
        }

        throw new PhotoNotFound('Photo with ID '.$photoId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): PhotoCollection
    {
        $photoCollection = new PhotoCollection();
        $photoCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->photoCollection->getIterator() as $key => $intervention) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $photoCollection->add($intervention);
                }
            }
        } else {
            $photoCollection = $this->photoCollection;
        }

        return $photoCollection;
    }
}