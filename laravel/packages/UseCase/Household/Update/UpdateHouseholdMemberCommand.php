<?php

namespace Packages\UseCase\Household\Update;

use Packages\Domain\Household\Relationship;
use Packages\Domain\ValueObject\Birthday;
use Packages\Domain\ValueObject\FirstName;
use Packages\Domain\ValueObject\LastName;

final class UpdateHouseholdMemberCommand
{
    /**
     * @param FirstName $firstName
     * @param LastName $lastName
     * @param Birthday $birthday
     * @param Relationship $relationship
     */
    public function __construct(
        private FirstName $firstName,
        private LastName $lastName,
        private Birthday $birthday,
        private Relationship $relationship
    ) {
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function birthday(): Birthday
    {
        return $this->birthday;
    }

    public function relationship(): Relationship
    {
        return $this->relationship;
    }
}
