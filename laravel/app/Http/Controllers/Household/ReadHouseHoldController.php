<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\Household\ReadHouseholdFormRequest;
use Illuminate\Http\JsonResponse;
use Packages\Domain\Household\Household;
use Packages\Domain\ValueObject\ID;
use Packages\UseCase\Household\Read\ReadHouseholdCommand;
use Packages\UseCase\Household\Read\ReadHouseholdUseCase;

/**
 * 世帯取得のコントローラ
 */
class ReadHouseholdController extends Controller
{
    /**
     * @param ReadHouseholdUseCase $readHouseholdUseCase
     */
    public function __construct(private ReadHouseholdUseCase $readHouseholdUseCase)
    {
    }

    /**
     * 世帯を取得する
     *
     * @param ReadHouseholdFormRequest $request
     */
    public function __invoke(ReadHouseholdFormRequest $request): JsonResponse
    {
        $command = $this->toCommand($request);

        $houseHold = $this->readHouseholdUseCase->handle($command);

        return $this->toResponse($houseHold);
    }

    /**
     * リクエストをコマンドに変換する
     *
     * @param ReadHouseholdFormRequest $request
     * @return ReadHouseholdCommand
     */
    private function toCommand(ReadHouseholdFormRequest $request): ReadHouseholdCommand
    {
        return new ReadHouseholdCommand(
            new ID($request->integer('householdId'))
        );
    }

    /**
     * 世帯エンティティをレスポンスに変換する
     *
     * @param Household $houseHold
     * @return JsonResponse
     */
    private function toResponse(Household $houseHold): JsonResponse
    {
        return response()->json([
            'id' => $houseHold->id()->value(),
            'phoneNumber' => $houseHold->phoneNumber()->value(),
            'email' => $houseHold->email()->value(),
            'postalCode' => $houseHold->postalCode()->value(),
            'address' => $houseHold->address()->value(),
            'householdMembers' => $houseHold->householdMembers()->map(function ($householdMember) {
                return [
                    'id' => $householdMember->id()?->value(),
                    'firstName' => $householdMember->firstName()->value(),
                    'lastName' => $householdMember->lastName()->value(),
                    'birthday' => $householdMember->birthday()->value(),
                    'relationship' => $householdMember->relationship()->value,
                ];
            })->toArray(),
        ]);
    }
}
