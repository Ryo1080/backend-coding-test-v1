<?php

namespace Packages\UseCase\Household\Update;

use Illuminate\Support\Facades\DB;
use Packages\Domain\Household\Household;
use Packages\Domain\Household\HouseholdMember;
use Packages\Domain\Household\HouseholdRepositoryInterface;

/**
 * 世帯更新のユースケース
 */
final class UpdateHouseholdUseCase
{
    /**
     * @param HouseholdRepositoryInterface $householdRepository
     */
    public function __construct(private HouseholdRepositoryInterface $householdRepository)
    {
    }

    /**
     * 世帯を更新する
     *
     * @param UpdateHouseholdCommand $command
     * @return Household
     */
    public function handle(UpdateHouseholdCommand $command): Household
    {
        // コマンドクラスをエンティティに変換
        $household = $this->toEntity($command);

        // トランザクション開始
        return DB::transaction(function () use ($household) {
            // 更新処理
            return $this->householdRepository->update($household);
        });
    }

    /**
     * コマンドをエンティティに変換する
     *
     * @param UpdateHouseholdCommand $command
     * @return Household
     */
    private function toEntity(UpdateHouseholdCommand $command): Household
    {
        // 世帯員のコマンドクラスをエンティティに変換
        $householdMembers = $command->householdMembers()->map(function (UpdateHouseholdMemberCommand $householdMember) {
            return new HouseholdMember(
                id: null,
                firstName: $householdMember->firstName(),
                lastName: $householdMember->lastName(),
                birthday: $householdMember->birthday(),
                relationship: $householdMember->relationship()
            );
        });

        // 世帯エンティティを生成
        return new Household(
            id: $command->id(),
            phoneNumber: $command->phoneNumber(),
            email: $command->email(),
            postalCode: $command->postalCode(),
            address: $command->address(),
            householdMembers: $householdMembers
        );
    }
}
