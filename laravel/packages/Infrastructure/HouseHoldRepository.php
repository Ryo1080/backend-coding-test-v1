<?php

namespace Packages\Infrastructure;

use App\Models\Household\Household;
use App\Models\Household\HouseholdMember;
use Packages\Domain\Household\Household as HouseholdEntity;
use Packages\Domain\Household\HouseholdMember as HouseholdMemberEntity;
use Packages\Domain\Household\HouseholdRepositoryInterface as HouseholdHouseholdRepositoryInterface;
use Packages\Domain\Household\Relationship;
use Packages\Domain\ValueObject\Address;
use Packages\Domain\ValueObject\Birthday;
use Packages\Domain\ValueObject\Email;
use Packages\Domain\ValueObject\FirstName;
use Packages\Domain\ValueObject\ID;
use Packages\Domain\ValueObject\LastName;
use Packages\Domain\ValueObject\PhoneNumber;
use Packages\Domain\ValueObject\PostalCode;

/**
 * 世帯のリポジトリ
 */
final class HouseholdRepository implements HouseholdHouseholdRepositoryInterface
{
    /**
     * IDに該当する世帯を取得する
     *
     * @param ID $id
     * @return HouseholdEntity | null
     */
    public function findById(ID $id): HouseholdEntity | null
    {
        $houseHold = Household::with('houseHoldMembers')->find($id->value());

        if (is_null($houseHold)) {
            return null;
        }

        return $this->toEntity($houseHold);
    }

    /**
     * 世帯を更新する
     *
     * @param HouseholdEntity $householdEntity
     * @return HouseholdEntity
     */
    public function update(HouseholdEntity $householdEntity): HouseholdEntity
    {
        // 対象の世帯を取得
        $houseHold = Household::find($householdEntity->id()->value());

        if (is_null($houseHold)) {
            throw new \RuntimeException('Household not found.');
        }

        // 世帯情報を更新
        $houseHold->phone_number = $householdEntity->phoneNumber()->value();
        $houseHold->email = $householdEntity->email()->value();
        $houseHold->postal_code = $householdEntity->postalCode()->value();
        $houseHold->address = $householdEntity->address()->value();
        $houseHold->save();

        // 世帯員情報を更新
        $houseHold->houseHoldMembers()->delete();
        $householdMembers = $householdEntity->householdMembers()->map(function (HouseholdMemberEntity $householdMemberEntity) {
            return new HouseholdMember([
                'first_name' => $householdMemberEntity->firstName()->value(),
                'last_name' => $householdMemberEntity->lastName()->value(),
                'birthday' => $householdMemberEntity->birthday()->value(),
                'relationship' => $householdMemberEntity->relationship()->value,
            ]);
        });
        $houseHold->houseHoldMembers()->saveMany($householdMembers);

        return $this->toEntity($houseHold);
    }

    /**
     * HouseholdモデルをHouseholdEntityに変換する
     *
     * @param Household $houseHold
     * @return HouseholdEntity
     */
    private function toEntity(Household $houseHold): HouseholdEntity
    {
        $houseHoldMembers = $houseHold->houseHoldMembers->map(function (HouseholdMember $houseHoldMember) {
            return new HouseholdMemberEntity(
                id: new ID($houseHoldMember->id),
                firstName: new FirstName($houseHoldMember->first_name),
                lastName: new LastName($houseHoldMember->last_name),
                birthday: new Birthday($houseHoldMember->birthday),
                relationship: Relationship::from($houseHoldMember->relationship),
            );
        });

        return new HouseholdEntity(
            id: new ID($houseHold->id),
            phoneNumber: new PhoneNumber($houseHold->phone_number),
            email: new Email($houseHold->email),
            postalCode: new PostalCode($houseHold->postal_code),
            address: new Address($houseHold->address),
            householdMembers: $houseHoldMembers,
        );
    }
}
