<?php

namespace Packages\UseCase\Household\Update;

use Illuminate\Support\Collection;
use Packages\Domain\ValueObject\Address;
use Packages\Domain\ValueObject\Email;
use Packages\Domain\ValueObject\ID;
use Packages\Domain\ValueObject\PhoneNumber;
use Packages\Domain\ValueObject\PostalCode;

final class UpdateHouseholdCommand
{
    /**
     * @param ID $id
     * @param PhoneNumber $phoneNumber
     * @param Email $email
     * @param Address $address
     * @param Collection<int, UpdateHouseholdMemberCommand> $householdMembers
     */
    public function __construct(
        private ID $id,
        private PhoneNumber $phoneNumber,
        private Email $email,
        private PostalCode $postalCode,
        private Address $address,
        private Collection $householdMembers
    ) {
    }

    /**
     * @return ID
     */
    public function id(): ID
    {
        return $this->id;
    }

    /**
     * @return PhoneNumber
     */
    public function phoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return PostalCode
     */
    public function postalCode(): PostalCode
    {
        return $this->postalCode;
    }

    /**
     * @return Address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * @return Collection<int, UpdateHouseholdMemberCommand>
     */
    public function householdMembers(): Collection
    {
        return $this->householdMembers;
    }
}
