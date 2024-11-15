<?php

namespace Tests\Feature\Household;

use App\Models\Household\Household;
use App\Models\Household\HouseholdMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateHouseholdTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Household $houseHold;

    protected function setUp(): void
    {
        parent::setUp();

        // 認証用ユーザーを作成
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // テストデータを準備
        $this->prepareTestData();
    }

    /**
     * 200 更新成功
     */
    public function test_200(): void
    {
        // リクエストパラメータの準備
        $body = [
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

        // APIを実行
        $headers = ['Accept' => 'application/json'];
        $response = $this->put("/api/households/{$this->houseHold->id}", $body, $headers);

        // レスポンスの検証
        $response->assertOk();
        $response->assertExactJson(
            [
                'id' => $this->houseHold->id,
                'phoneNumber' => '1234567890',
                'email' => 'test@example.com',
                'postalCode' => '1234567',
                'address' => '東京都千代田区',
                'householdMembers' => [
                    [
                        'id' => $this->houseHold->householdMembers[0]->id,
                        'firstName' => '太郎',
                        'lastName' => '山田',
                        'birthday' => '2000-01-01',
                        'relationship' => 1,
                    ],
                ],
            ]
        );

        // データベースの検証
        $this->assertDatabaseHas('households', [
            'id' => $this->houseHold->id,
            'phone_number' => '1234567890',
            'email' => 'test@example.com',
            'postal_code' => '1234567',
            'address' => '東京都千代田区',
        ]);
        $this->assertDatabaseHas('household_members', [
            'id' => $this->houseHold->householdMembers[0]->id,
            'household_id' => $this->houseHold->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'birthday' => '2000-01-01',
            'relationship' => 1,
        ]);
    }

    /**
     * 422 バリデーションエラー
     */
    public function test_422(): void
    {
        $headers = ['Accept' => 'application/json'];

        // APIを実行
        // 存在しないIDを指定
        $response = $this->put('/api/households/999', [], $headers);

        // レスポンスの検証
        $response->assertUnprocessable();
        $response->assertJson([
            'message' => '指定された世帯IDは存在しません。 (and 5 more errors)',
            'errors' => [
                'householdId' => [
                    '指定された世帯IDは存在しません。',
                ],
                'phoneNumber' => [
                    '電話番号を入力してください。'
                ],
                'email' => [
                    'メールアドレスを入力してください。'
                ],
                'postalCode' => [
                    '郵便番号を入力してください。'
                ],
                'address' => [
                    '住所を入力してください。'
                ],
                'householdMembers' => [
                    '世帯員を入力してください。'
                ],
            ],
        ]);
    }

    /**
     * テストデータを準備する
     */
    private function prepareTestData(): void
    {
        $this->houseHold = Household::factory()->create([
            'phone_number' => '1234567890',
            'email' => 'test@example.com',
            'postal_code' => '1234567',
            'address' => '東京都千代田区',
        ]);

        HouseholdMember::factory()->create([
            'household_id' => $this->houseHold->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'birthday' => '2000-01-01',
            'relationship' => 1,
        ]);

        HouseholdMember::factory()->create([
            'household_id' => $this->houseHold->id,
            'first_name' => '花子',
            'last_name' => '山田',
            'birthday' => '2000-01-01',
            'relationship' => 2,
        ]);
    }
}
