<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->comment('世帯');

            $table->id()->comment('ID');
            $table->string('phone_number', 11)->comment('電話番号');
            $table->string('email')->comment('メールアドレス');
            $table->string('postal_code', 7)->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
