<?php

namespace Tests\Unit\Household;

use App\Http\Requests\Household\ReadHouseholdFormRequest;
use App\Models\Household\Household;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ReadHouseholdFormRequestTest extends TestCase
{
    /**
     * すべてのバリデーション通過
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

        $params = ['householdId' => $household->id];
        $formRequest = new ReadHouseholdFormRequest();
        $validator = Validator::make(
            $params,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );

        try {
            // バリデーション実行
            $validator->validate();
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->fail('ValidationExceptionが発生しました');
        }
    }

    /**
     * householdId が存在しない場合、バリデーションエラーが発生すること
     */
    public function testFailHouseholdIdRequired(): void
    {
        $params = [];
        $formRequest = new ReadHouseholdFormRequest();
        $validator = Validator::make(
            $params,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('世帯IDを入力してください。', $e->errors()['householdId']);
        }
    }

    /**
     * householdId が数値でない場合、バリデーションエラーが発生すること
     */
    public function testFailHouseholdIdNumeric(): void
    {
        $params = ['householdId' => 'string'];
        $formRequest = new ReadHouseholdFormRequest();
        $validator = Validator::make(
            $params,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );

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
     * householdId が存在しないIDの場合、バリデーションエラーが発生すること
     */
    public function testFailHouseholdIdExists(): void
    {
        $params = ['householdId' => 999];
        $formRequest = new ReadHouseholdFormRequest();
        $validator = Validator::make(
            $params,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );

        try {
            // バリデーション実行
            $validator->validate();
            $this->fail('ValidationExceptionが発生しませんでした');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertContains('指定された世帯IDは存在しません。', $e->errors()['householdId']);
        }
    }
}
