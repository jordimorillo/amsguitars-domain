<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Person;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Address;
use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Country;
use AMSGuitars\Domain\ValueObjects\Email;
use AMSGuitars\Domain\ValueObjects\Firstname;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Lastname;
use AMSGuitars\Domain\ValueObjects\Types\PersonType;
use AMSGuitars\Domain\ValueObjects\PhoneNumber;
use AMSGuitars\Domain\ValueObjects\Region;
use AMSGuitars\Domain\ValueObjects\Zipcode;

class Person implements Entity
{
    public PersonId $personId;
    public Firstname $firstname;
    public Lastname $lastname;
    private Zipcode $zipCode;
    private Address $address;
    private Region $region;
    private Country $country;
    private PhoneNumber $phoneNumber;
    private Email $email;
    private GuitarCollection $guitarCollection;
    private PersonType $personType;

    public function __construct(
        PersonId $personId,
        PersonType $personType,
        Firstname $firstname,
        Lastname $lastname,
        Zipcode $zipCode,
        Address $address,
        Region $region,
        Country $country,
        PhoneNumber $phoneNumber,
        Email $email,
        GuitarCollection $guitarCollection
    ) {
        $this->personId = $personId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->zipCode = $zipCode;
        $this->address = $address;
        $this->region = $region;
        $this->country = $country;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->guitarCollection = $guitarCollection;
        $this->personType = $personType;
    }

    public function toArray(): array
    {
        return [
            'personId' => $this->getPersonId()->toString(),
            'personType' => $this->getPersonType()->getValue(),
            'firstname' => $this->getFirstname()->toString(),
            'lastname' => $this->getLastname()->toString(),
            'zipCode' => $this->getZipCode()->toString(),
            'address' => $this->getAddress()->toString(),
            'region' => $this->getRegion()->toString(),
            'country' => $this->getCountry()->toString(),
            'phoneNumber' => $this->getPhoneNumber()->toString(),
            'email' => $this->getEmail()->toString(),
            'guitarCollection' => json_encode($this->getGuitarCollection()->toArray()),
        ];
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }

    public function getPersonType(): PersonType
    {
        return $this->personType;
    }

    public function getFirstname(): Firstname
    {
        return $this->firstname;
    }

    public function getLastname(): Lastname
    {
        return $this->lastname;
    }

    public function getZipCode(): Zipcode
    {
        return $this->zipCode;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getGuitarCollection(): GuitarCollection
    {
        return $this->guitarCollection;
    }
}