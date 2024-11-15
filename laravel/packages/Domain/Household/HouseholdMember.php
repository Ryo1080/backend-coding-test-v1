<?php

namespace Packages\Domain\Household;

use Packages\Domain\ValueObject\Birthday;
use Packages\Domain\ValueObject\FirstName;
use Packages\Domain\ValueObject\ID;
use Packages\Domain\ValueObject\LastName;

/**
 * 世帯員エンティティ
 */
final class HouseholdMember
{
    /**
     * @param ID | null $id
     * @param FirstName $firstName
     * @param LastName $lastName
     * @param Birthday $birthday
     * @param Relationship $relationship
     */
    public function __construct(
        private ID | null $id,
        private FirstName $firstName,
        private LastName $lastName,
        private Birthday $birthday,
        private Relationship $relationship
    ) {
    }

    /**
     * @return ID | null
     */
    public function id(): ID | null
    {
        return $this->id;
    }

    /**
     * @return FirstName
     */
    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * @return LastName
     */
    public function lastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * @return Birthday
     */
    public function birthday(): Birthday
    {
        return $this->birthday;
    }

    /**
     * @return Relationship
     */
    public function relationship(): Relationship
    {
        return $this->relationship;
    }
}
