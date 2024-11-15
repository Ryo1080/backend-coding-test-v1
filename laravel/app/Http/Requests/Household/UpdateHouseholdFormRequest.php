<?php

namespace App\Http\Requests\Household;

use App\Rules\UniqueSelfRelationship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Packages\Domain\Household\Relationship;
use Packages\Domain\ValueObject\Birthday;
use Packages\Domain\ValueObject\Email;
use Packages\Domain\ValueObject\PhoneNumber;
use Packages\Domain\ValueObject\PostalCode;

class UpdateHouseholdFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $phoneNumberPattern = PhoneNumber::PATTERN;
        $emailPattern = Email::PATTERN;
        $postalCodePattern = PostalCode::PATTERN;
        $birthdayPattern = Birthday::PATTERN;

        return [
            'householdId' => ['required', 'integer', 'exists:households,id'],
            'phoneNumber' => ['required', 'string', "regex:{$phoneNumberPattern}"],
            'email' => ['required', 'string', "regex:{$emailPattern}"],
            'postalCode' => ['required', 'string', "regex:{$postalCodePattern}"],
            'address' => ['required', 'string'],
            'householdMembers' => ['required', 'array', new UniqueSelfRelationship()],
            'householdMembers.*.firstName' => ['required', 'string'],
            'householdMembers.*.lastName' => ['required', 'string'],
            'householdMembers.*.birthday' => ['required', 'date', "regex:{$birthdayPattern}"],
            'householdMembers.*.relationship' => ['required', Rule::enum(Relationship::class)],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'householdId' => $this->route('householdId'),
        ]);
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'householdId' => '世帯ID',
            'phoneNumber' => '電話番号',
            'email' => 'メールアドレス',
            'postalCode' => '郵便番号',
            'address' => '住所',
            'householdMembers' => '世帯員',
            'householdMembers.*.firstName' => '世帯員の名',
            'householdMembers.*.lastName' => '世帯員の姓',
            'householdMembers.*.birthday' => '世帯員の誕生日',
            'householdMembers.*.relationship' => '世帯員の続柄',
        ];
    }
}
