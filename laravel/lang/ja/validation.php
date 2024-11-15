<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'required' => ':attributeを入力してください。',
    'integer' => ':attributeは整数で入力してください。',
    'string' => ':attributeは文字列で入力してください。',
    'date' => ':attributeは日付で入力してください。',
    'array' => ':attributeは配列で入力してください。',
    'exists' => '指定された:attributeは存在しません。',
    'enum' => ':attributeを正しく入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'phoneNumber' => [
            'regex' => '電話番号は 10 桁もしくは 11 桁の半角数字を入力してください。',
        ],
        'email' => [
            'regex' => 'メールアドレスの形式で入力してください。',
        ],
        'postalCode' => [
            'regex' => '郵便番号は 7 桁の半角数字を入力してください。',
        ],
        'householdMembers' => [
            'uniqueSelfRelationship' => '世帯員の中に「本人」が存在しない、または複数人存在する場合: 世帯主との続柄が「本人」となる世帯員が 1 人存在する必要があります。',
        ],
        'householdMembers.*.birthday' => [
            'regex' => '世帯員の誕生日を正しく入力してください。',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
