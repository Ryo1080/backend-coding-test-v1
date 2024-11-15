<?php

namespace Packages\UseCase\Household\Read;

use Packages\Domain\Household\Household;
use Packages\Domain\Household\HouseholdRepositoryInterface;

/**
 * 世帯取得のユースケース
 */
final class ReadHouseholdUseCase
{
    /**
     * @param HouseholdRepositoryInterface $houseHoldRepository
     */
    public function __construct(private HouseholdRepositoryInterface $houseHoldRepository)
    {
    }

    /**
     * 世帯を取得する
     *
     * @param ReadHouseholdCommand $command
     * @return Household
     */
    public function handle(ReadHouseholdCommand $command): Household
    {
        $houseHold =  $this->houseHoldRepository->findById($command->id());

        if (is_null($houseHold)) {
            throw new \RuntimeException('Household not found.');
        }

        return $houseHold;
    }
}
