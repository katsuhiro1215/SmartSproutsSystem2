<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('ユーザーID');
            $table->string('postalcode', 7)->comment('郵便番号');
            $table->string('prefecture', 10)->comment('都道府県名');
            $table->string('city', 30)->comment('市区町村名');
            $table->string('address1', 50)->comment('町名・番地');
            $table->string('address2', 100)->comment('建物名など');
            $table->string('phone_number', 15)->comment('電話番号')->nullable();
            $table->boolean('is_default')->default(false)->comment('デフォルトの住所かどうか');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
