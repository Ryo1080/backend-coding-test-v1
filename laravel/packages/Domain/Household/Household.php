<?php

namespace Packages\Domain\Household;

use Illuminate\Support\Collection;
use Packages\Domain\ValueObject\Address;
use Packages\Domain\ValueObject\Email;
use Packages\Domain\ValueObject\ID;
use Packages\Domain\ValueObject\PhoneNumber;
use Packages\Domain\ValueObject\PostalCode;

/**
 * 世帯エンティティ
 */
final class Household
{
    /**
     * @param ID $id
     * @param PhoneNumber $phoneNumber
     * @param Email $email
     * @param PostalCode $postalCode
     * @param Address $address
     * @param Collection<int, HouseholdMember> $householdMembers
     */
    public function __construct(
        private ID $id,
        private PhoneNumber $phoneNumber,
        private Email $email,
        private PostalCode $postalCode,
        private Address $address,
        private Collection $householdMembers,
    ) {
        // 世帯員の中に世帯主との続柄が「本人」となる人が1人だけ存在するか確認する
        if (!$this->uniqueSelfRelationshipMember()) {
            throw new \InvalidArgumentException('The household must have one member with a relationship of "self".');
        }
    }

    /**
     * 世帯員の中に世帯主との続柄が「本人」となる人が1人だけ存在するか確認する
     */
    private function uniqueSelfRelationshipMember(): bool
    {
        $selfRelationshipMembers = $this->householdMembers->filter(function (HouseholdMember $householdMember) {
            return $householdMember->relationship() === Relationship::SELF;
        });

        return $selfRelationshipMembers->count() === 1;
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
     * @return Collection<int, HouseholdMember>
     */
    public function householdMembers(): Collection
    {
        return $this->householdMembers;
    }
}
