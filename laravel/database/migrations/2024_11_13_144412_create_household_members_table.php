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
        Schema::create('household_members', function (Blueprint $table) {
            $table->comment('世帯員');

            $table->id()->comment('ID');
            $table->foreignId('household_id')->constrained()->onDelete('cascade')->comment('世帯ID');
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->date('birthday')->comment('生年月日');
            $table->tinyInteger('relationship')->comment('世帯主との続柄');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_members');
    }
};
