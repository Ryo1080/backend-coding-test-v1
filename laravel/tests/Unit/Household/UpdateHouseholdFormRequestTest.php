<?php

namespace Tests\Unit\Household;

use App\Http\Requests\Household\UpdateHouseholdFormRequest;
use App\Models\Household\Household;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateHouseholdFormRequestTest extends TestCase
{
    /**
     * すべてのバリデーションが通過すること
     */
    public function testSuccessAll(): void
    {
        // テストデータ
        $household = Household::factory()->create([
            'phone_number' => '1234567890',
            'email' => 'test@example.com',
            'postal_code' => '1234567',
            'address' => '東京都千代田区',
        ]);

        // リクエストパラメータの準備
        $params = [
            'householdId' => $household->id,
            'phoneNumber' => '1234567890',
            'email' => 'test@example.com',
            'postalCode' => '1234567',
            'address' => '東京都千代田区',
            'householdMembers' => [
                [
                    'firstName' => '太郎',
                    'lastName' => '山田',
                    'birthday' => '2000-01-01',
                    'relationship' => 1,
                ],
            ],
        ];

        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->fail('ValidationExceptionが発生しました');
        }
    }

    /**
     * 必須項目が存在しない場合、バリデーションエラーが発生すること
     */
    public function testFailRequired(): void
    {
        $params = [];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯IDを入力してください。', $e->errors()['householdId']);
            $this->assertContains('電話番号を入力してください。', $e->errors()['phoneNumber']);
            $this->assertContains('メールアドレスを入力してください。', $e->errors()['email']);
            $this->assertContains('郵便番号を入力してください。', $e->errors()['postalCode']);
            $this->assertContains('住所を入力してください。', $e->errors()['address']);
            $this->assertContains('世帯員を入力してください。', $e->errors()['householdMembers']);
        }

        // householdMembers の要素を確認
        $params = [
            'householdMembers' => [[]],
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の名を入力してください。', $e->errors()['householdMembers.0.firstName']);
            $this->assertContains('世帯員の姓を入力してください。', $e->errors()['householdMembers.0.lastName']);
            $this->assertContains('世帯員の誕生日を入力してください。', $e->errors()['householdMembers.0.birthday']);
            $this->assertContains('世帯員の続柄を入力してください。', $e->errors()['householdMembers.0.relationship']);
        }
    }

    /**
     * 数値項目に数値以外が入力された場合、バリデーションエラーが発生すること
     */
    public function testFailInteger(): void
    {
        $params = ['householdId' => 'string'];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯IDは整数で入力してください。', $e->errors()['householdId']);
        }
    }

    /**
     * 文字列項目に文字列以外が入力された場合、バリデーションエラーが発生すること
     */
    public function testFailString(): void
    {
        $params = [
            'phoneNumber' => 1234567890,
            'email' => 123,
            'postalCode' => 1234567,
            'address' => 123,
            'householdMembers' => [
                [
                    'firstName' => 123,
                    'lastName' => 123,
                ],
            ],
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('電話番号は文字列で入力してください。', $e->errors()['phoneNumber']);
            $this->assertContains('メールアドレスは文字列で入力してください。', $e->errors()['email']);
            $this->assertContains('郵便番号は文字列で入力してください。', $e->errors()['postalCode']);
            $this->assertContains('住所は文字列で入力してください。', $e->errors()['address']);
            $this->assertContains('世帯員の名は文字列で入力してください。', $e->errors()['householdMembers.0.firstName']);
            $this->assertContains('世帯員の姓は文字列で入力してください。', $e->errors()['householdMembers.0.lastName']);
        }
    }

    /**
     * 配列項目に配列以外が入力された場合、バリデーションエラーが発生すること
     */
    public function testFailArray(): void
    {
        $params = ['householdMembers' => 'string'];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員は配列で入力してください。', $e->errors()['householdMembers']);
        }
    }

    /**
     * 日付項目に日付以外が入力された場合、バリデーションエラーが発生すること
     */
    public function testFailDate(): void
    {
        $params = [
            'householdMembers' => [
                [
                    'birthday' => 'string',
                ],
            ],
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の誕生日は日付で入力してください。', $e->errors()['householdMembers.0.birthday']);
        }
    }

    /**
     * 世帯IDが存在しない場合、バリデーションエラーが発生すること
     */
    public function testFailHouseholdIdExists(): void
    {
        $params = ['householdId' => 999];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('指定された世帯IDは存在しません。', $e->errors()['householdId']);
        }
    }

    /**
     * 電話番号の形式が正しくない場合、バリデーションエラーが発生すること
     */
    public function testFailPhoneNumberFormat(): void
    {
        $params = ['phoneNumber' => '123456789']; // 9桁
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('電話番号は 10 桁もしくは 11 桁の半角数字を入力してください。', $e->errors()['phoneNumber']);
        }
    }

    /**
     * メールアドレスの形式が正しくない場合、バリデーションエラーが発生すること
     */
    public function testFailEmailFormat(): void
    {
        $params = ['email' => 'test.example.com'];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('メールアドレスの形式で入力してください。', $e->errors()['email']);
        }
    }

    /**
     * 郵便番号の形式が正しくない場合、バリデーションエラーが発生すること
     */
    public function testFailPostalCodeFormat(): void
    {
        $params = ['postalCode' => '123'];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('郵便番号は 7 桁の半角数字を入力してください。', $e->errors()['postalCode']);
        }
    }

    /**
     * 誕生日の形式が正しくない場合、バリデーションエラーが発生すること
     */
    public function testFailBirthdayFormat(): void
    {
        $params = [
            'householdMembers' => [
                [
                    'birthday' => '1992/07/09' // 不正なフォーマット
                ]
            ]
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の誕生日を正しく入力してください。', $e->errors()['householdMembers.0.birthday']);
        }
    }

    /**
     * 世帯員の中に「本人」が存在しない、または複数人存在する場合、バリデーションエラーになること
     */
    public function testFailUniqueSelfRelationship(): void
    {
        $params = [
            'householdMembers' => [
                [
                    'relationship' => 2 // 本人が存在しない
                ],
            ]
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の中に「本人」が存在しない、または複数人存在する場合: 世帯主との続柄が「本人」となる世帯員が 1 人存在する必要があります。', $e->errors()['householdMembers']);
        }

        $params = [
            'householdMembers' => [
                [
                    'relationship' => 1
                ],
                [
                    'relationship' => 1
                ],
            ]
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の中に「本人」が存在しない、または複数人存在する場合: 世帯主との続柄が「本人」となる世帯員が 1 人存在する必要があります。', $e->errors()['householdMembers']);
        }
    }

    /**
     * 世帯員の続柄が不正な値の場合、バリデーションエラーになること
     */
    public function testFailInvalidRelationship(): void
    {
        $params = [
            'householdMembers' => [
                [
                    'relationship' => 99
                ],
            ]
        ];
        $validator = $this->createValidator($params);

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯員の続柄を正しく入力してください。', $e->errors()['householdMembers.0.relationship']);
        }
    }

    /**
     * バリデータを作成
     */
    private function createValidator(array $params): \Illuminate\Contracts\Validation\Validator
    {
        $formRequest = new UpdateHouseholdFormRequest();
        return Validator::make(
            $params,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );
    }
}
