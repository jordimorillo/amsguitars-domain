<?php

declare(strict_types=1);

namespace Tests;

use AMSGuitars\Infrastructure\Persistence\MySQL;
use AMSGuitars\Infrastructure\Persistence\Repository;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        if($this->getProvidedData()[0] instanceOf Repository) {
            MySQL::createDatabase();
            MySQL::selectDatabase($_ENV['MYSQL_DATABASE']);
            MySQL::createStructure();
        }
    }

    public function tearDown(): void
    {
        if($this->getProvidedData()[0] instanceOf Repository) {
            MySQL::dropDatabase();
        }
        parent::tearDown();
    }
}