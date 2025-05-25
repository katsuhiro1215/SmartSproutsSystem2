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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('イベント名');
            $table->text('description', 1000)->comment('イベント概要');
            $table->string('event_photo_path')->nullable()->comment('イベント画像');
            $table->string('postalcode', 7)->nullable()->comment('郵便番号');
            $table->string('prefecture', 10)->nullable()->comment('都道府県名');
            $table->string('city', 30)->nullable()->comment('市区町村名');
            $table->string('address1', 50)->nullable()->comment('町域名');
            $table->string('address2', 100)->nullable()->comment('それ以降の住所');
            $table->string('phone_number', 15)->nullable()->comment('電話番号');
            $table->boolean('status')->default(true)->comment('イベントの状態');
            $table->date('event_start_date')->comment('イベント開始日');
            $table->date('event_end_date')->comment('イベント終了日');
            $table->date('application_start_date')->comment('申込開始日');
            $table->time('application_start_time')->comment('申込開始時間');
            $table->date('application_end_date')->comment('申込終了日');
            $table->time('application_end_time')->comment('申込終了時間');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
