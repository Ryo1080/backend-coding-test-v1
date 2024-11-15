<?php

namespace Packages\Domain\Household;

use Packages\Domain\ValueObject\ID;

/**
 * 世帯のリポジトリインターフェース
 */
interface HouseholdRepositoryInterface
{
    /**
     * IDに該当する世帯を取得する
     *
     * @param ID $id
     * @return Household | null
     */
    public function findById(ID $id): Household | null;

    /**
     * 世帯を更新する
     *
     * @param Household $household
     * @return Household
     */
    public function update(Household $household): Household;
}
