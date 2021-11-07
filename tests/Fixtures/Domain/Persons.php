<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\Entities\Person\Person;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Address;
use AMSGuitars\Domain\ValueObjects\Country;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Firstname;
use AMSGuitars\Domain\ValueObjects\Lastname;
use AMSGuitars\Domain\ValueObjects\Types\PersonType;
use AMSGuitars\Domain\ValueObjects\PhoneNumber;
use AMSGuitars\Domain\ValueObjects\Region;
use AMSGuitars\Domain\ValueObjects\Zipcode;

class Persons extends FakeEntityGenerator
{
    public function aCustomer(): Person
    {
        $guitar = new Guitars();

        $zipCode = 0;
        while($zipCode < 10000) {
            $zipCode = $this->faker->postcode;
        }

        return new Person(
            new PersonId(),
            PersonType::CUSTOMER(),
            new Firstname($this->faker->firstName),
            new Lastname($this->faker->lastName),
            new Zipcode($zipCode),
            new Address($this->faker->address),
            new Region($this->faker->state),
            new Country($this->faker->country),
            new PhoneNumber($this->faker->phoneNumber),
            new Email($this->faker->email),
            new GuitarCollection(
                [
                    $guitar->aGuitar()
                ]
            )
        );
    }
}