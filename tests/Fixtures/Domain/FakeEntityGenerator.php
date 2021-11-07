<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use Faker\Factory;
use Faker\Generator;

class FakeEntityGenerator
{
    protected Generator $faker;

    public function __construct() {
        $this->faker = Factory::create('es_ES');
    }
}