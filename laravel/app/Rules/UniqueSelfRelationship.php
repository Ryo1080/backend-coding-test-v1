<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Packages\Domain\Household\Relationship;

/**
 * 世帯員の中に世帯主との続柄が「本人」となる人が1人だけ存在するか確認するバリデーションルール
 */
class UniqueSelfRelationship implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $valueが配列であることを確認
        if (!is_array($value)) {
            $fail('$value must be an array.');
            return;
        }

        $selfCount = collect($value)->filter(function ($value) {
            if (!isset($value['relationship'])) {
                return false; // 続柄の必須チェックは他のバリデーションルールで行う
            }
            return $value['relationship'] === Relationship::SELF->value;
        })->count();

        if ($selfCount !== 1) {
            $fail('validation.custom.householdMembers.uniqueSelfRelationship')->translate();
        }
    }
}
