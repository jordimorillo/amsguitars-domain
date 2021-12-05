<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\Entities\Guitar\GuitarRepositoryInterface;
use AMSGuitars\Domain\Entities\Photo\Photo;
use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Infrastructure\Adapters\Guitar\GuitarCollectionAdapter;
use AMSGuitars\Infrastructure\Adapters\Intervention\InterventionCollectionAdapter;
use AMSGuitars\Infrastructure\Adapters\Photo\PhotoAdapter;
use AMSGuitars\Infrastructure\Adapters\Photo\PhotoCollectionAdapter;
use AMSGuitars\Infrastructure\Exceptions\GuitarNotFound;
use AMSGuitars\Infrastructure\Exceptions\GuitarRepositoryException;
use AMSGuitars\Infrastructure\Exceptions\MySQLException;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use mysqli;

class GuitarRepositoryInMySQL implements GuitarRepositoryInterface, Repository
{
    private mysqli $mysqli;

    public function __construct(mysqli $mysqli) {
        $this->mysqli = $mysqli;
    }

    public function save(Guitar $guitar): void
    {
        $stmt = $this->mysqli->prepare("INSERT INTO guitars (guitarId, personId, modelId, interventionCollection)
            VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE personId = VALUES(personId), modelId = VALUES(modelId), interventionCollection = VALUES(interventionCollection);");
        $stmt->bind_param('ssss', $guitarId, $personId, $modelId, $interventionCollection);
        $guitarId = $guitar->getGuitarId()->toString();
        $personId = $guitar->getPersonId()->toString();
        $modelId = $guitar->getModelId()->toString();
        $interventionCollection = $guitar->getInterventionCollection()->toJson();
        if($stmt->execute() === false) {
            throw new GuitarRepositoryException('Cannot save the guitar');
        }
    }

    public function findById(GuitarId $guitarId): Guitar
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM guitars WHERE guitarId = ?");
        $stmt->bind_param('s', $guitarIdValue);
        $guitarIdValue = $guitarId->toString();
        if($stmt->execute() === false) {
            throw new GuitarRepositoryException('Cannot execute the query');
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row === false || $row === null) {
            throw new GuitarNotFound('Guitar with ID '.$guitarId.' not found');
        }
        return $this->rowToGuitar($row);
    }

    public function findCollection(SortOrder $order, Limit $limit): GuitarCollection
    {
        $stmt = $this->mysqli->prepare('SELECT * FROM guitars ORDER BY ? LIMIT ?,?');
        $stmt->bind_param('sii', $sortOrderValue, $limitStart, $limitEnd);
        $sortOrderValue = $order->getColumn()->toString() . ' ' . $order->getSortDirection()->getValue();
        $limitStart = $limit->getStartPosition();
        $limitEnd = $limit->getTotalItems();
        if ($stmt->execute() === false) {
            throw new GuitarRepositoryException('Failed while finding the guitar collection');
        }
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return GuitarCollectionAdapter::fromRows($rows);
    }

    private function rowToGuitar(array $row): Guitar
    {
        return new Guitar(
            new GuitarId($row['guitarId']),
            new PersonId($row['personId']),
            new ModelId($row['modelId']),
            InterventionCollectionAdapter::fromRow(json_decode($row['interventionCollection'], true))
        );
    }
}