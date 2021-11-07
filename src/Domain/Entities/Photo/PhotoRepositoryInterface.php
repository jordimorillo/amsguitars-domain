<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Photo;

use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface PhotoRepositoryInterface
{
    public function save(Photo $photo): void;
    public function findById(PhotoId $photoId): Photo;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): PhotoCollection;
}