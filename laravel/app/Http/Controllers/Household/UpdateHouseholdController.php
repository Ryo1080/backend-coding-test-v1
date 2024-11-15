<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\Household\UpdateHouseholdFormRequest;
use Illuminate\Http\JsonResponse;
use Packages\Domain\Household\Household;
use Packages\Domain\Household\Relationship;
use Packages\Domain\ValueObject\Address;
use Packages\Domain\ValueObject\Birthday;
use Packages\Domain\ValueObject\Email;
use Packages\Domain\ValueObject\FirstName;
use Packages\Domain\ValueObject\ID;
use Packages\Domain\ValueObject\LastName;
use Packages\Domain\ValueObject\PhoneNumber;
use Packages\Domain\ValueObject\PostalCode;
use Packages\UseCase\Household\Update\UpdateHouseholdCommand;
use Packages\UseCase\Household\Update\UpdateHouseholdMemberCommand;
use Packages\UseCase\Household\Update\UpdateHouseholdUseCase;

/**
 * 世帯取得のコントローラ
 */
class UpdateHouseholdController extends Controller
{
    /**
     * @param UpdateHouseholdUseCase $updateHouseholdUseCase
     */
    public function __construct(private UpdateHouseholdUseCase $updateHouseholdUseCase)
    {
    }

    /**
     * 世帯を更新する
     *
     * @param UpdateHouseholdFormRequest $request
     * @return JsonResponse
     */
    public function __invoke(UpdateHouseholdFormRequest $request): JsonResponse
    {
        $command = $this->toCommand($request);

        $houseHold = $this->updateHouseholdUseCase->handle($command);

        return $this->toResponse($houseHold);
    }

    /**
     * リクエストデータをコマンドクラスに変換する
     *
     * @param UpdateHouseholdFormRequest $request
     * @return UpdateHouseholdCommand
     */
    private function toCommand(UpdateHouseholdFormRequest $request): UpdateHouseholdCommand
    {
        /** @var array<int, array{firstName: string, lastName: string, birthday: string, relationship: int}> $houseHoldMemberInput */
        $houseHoldMemberInput = $request->input('householdMembers');

        // 世帯員のコマンドクラスを生成
        $householdMembers = collect($houseHoldMemberInput)->map(function ($householdMember) {
            return new UpdateHouseholdMemberCommand(
                firstName: new FirstName($householdMember['firstName']),
                lastName: new LastName($householdMember['lastName']),
                birthday: new Birthday($householdMember['birthday']),
                relationship: Relationship::from($householdMember['relationship'])
            );
        });

        // 世帯のコマンドクラスを生成
        return new UpdateHouseholdCommand(
            id: new ID($request->integer('householdId')),
            phoneNumber: new PhoneNumber($request->string('phoneNumber')),
            email: new Email($request->string('email')),
            postalCode: new PostalCode($request->string('postalCode')),
            address: new Address($request->string('address')),
            householdMembers: $householdMembers
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
